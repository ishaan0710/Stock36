


import numpy as np
import tensorflow as tf
import pandas as pd
import matplotlib.pyplot as plt
from sklearn.preprocessing import StandardScaler



# In[2]:
print("matplot imported")

import quandl, math
quandl.ApiConfig.api_key = 'D7DzdfFAbVsz3sHSnDST' 

print("quandl imported")
# In[3]:


df1 = quandl.get("EOD/INTC")
df2 = quandl.get("EOD/CSCO")
df3 = quandl.get("EOD/AAPL")
df4 = quandl.get("EOD/MSFT")
print("previous data fetched")

print("Reading data complete")

file=open("PRED.csv", "w")
file.close()


def func(df1,ticker):

	def extra_col(df):
	    df['HL_PCT'] = (df['Adj_High'] - df['Adj_Low']) / df['Adj_Close'] * 100.0
	    df['PCT_change'] = (df['Adj_Close'] - df['Adj_Open']) / df['Adj_Open'] * 100.0
	    return df
	df1 = extra_col(df1)




	df5=df1[['Open','High','Low','Close','Volume','HL_PCT','PCT_change']]




	target=df5['Close'].values

	


	scaler=StandardScaler()
	scaled_df5=scaler.fit_transform(target.reshape(-1, 1))




	def batch(data, batch_size):
	    X=[]
	    y=[]
	    
	    i=0
	    while(i+batch_size)<=len(data)-1:
	        X.append(data[i:i+batch_size])
	        y.append(data[i+batch_size])
	        i+=1
	    return X, y


	# In[14]:


	X, y=batch(scaled_df5, 7)


	# In[15]:


	#changed
	X_train  = np.array(X[:int(scaled_df5.shape[0]*0.2)])
	y_train = np.array(y[:int(scaled_df5.shape[0]*0.2)])

	X_test = np.array(X[int(scaled_df5.shape[0]*0.2):])
	y_test = np.array(y[int(scaled_df5.shape[0]*0.2):])





	epochs=200
	batch_size=7


	# In[19]:


	def LSTM_cell(hidden_layer_size, batch_size,number_of_layers, dropout=True, dropout_rate=0.5):
	    layer = tf.contrib.rnn.BasicLSTMCell(hidden_layer_size)
	    if dropout:
	        layer = tf.contrib.rnn.DropoutWrapper(layer, output_keep_prob=dropout_rate)
	    cell = tf.contrib.rnn.MultiRNNCell([layer]*number_of_layers)
	    init_state = cell.zero_state(batch_size, tf.float32)
	    return cell, init_state


	# In[20]:


	def output_layer(lstm_output, in_size, out_size):
	    x = lstm_output[:, -1, :]
	    print(x)
	    weights = tf.Variable(tf.truncated_normal([in_size, out_size], stddev=0.05), name='output_layer_weights')
	    bias = tf.Variable(tf.zeros([out_size]), name='output_layer_bias')
	    output = tf.matmul(x, weights) + bias
	    return output


	# In[21]:


	def opt_loss(logits, targets, learning_rate, grad_clip_margin):
	    losses = []
	    for i in range(targets.get_shape()[0]):
	        losses.append([(tf.pow(logits[i] - targets[i], 2))])    
	    loss = tf.reduce_sum(losses)/(2*batch_size)
	    #Cliping the gradient loss
	    gradients = tf.gradients(loss, tf.trainable_variables())
	    clipper_, _ = tf.clip_by_global_norm(gradients, grad_clip_margin)
	    optimizer = tf.train.AdamOptimizer(learning_rate)
	    train_optimizer = optimizer.apply_gradients(zip(gradients, tf.trainable_variables()))
	    return loss, train_optimizer


	# In[27]:


	class StockPredictionRNN(object):
	    
	    def __init__(self, learning_rate=0.001, batch_size=7, hidden_layer_size=128, number_of_layers=1, 
	                 dropout=True, dropout_rate=0.5, number_of_classes=1, gradient_clip_margin=4, window_size=7):
	    
	        self.inputs = tf.placeholder(tf.float32, [batch_size, window_size, 1], name='input_data')
	        self.targets = tf.placeholder(tf.float32, [batch_size, 1], name='targets')

	        cell, init_state = LSTM_cell(hidden_layer_size, batch_size, number_of_layers, dropout, dropout_rate)

	        outputs, states = tf.nn.dynamic_rnn(cell, self.inputs, initial_state=init_state)

	        self.logits = output_layer(outputs, hidden_layer_size, number_of_classes)

	        self.loss, self.opt = opt_loss(self.logits, self.targets, learning_rate, gradient_clip_margin)


	# In[28]:


	tf.reset_default_graph()
	model = StockPredictionRNN()


	# In[29]:


	session =  tf.Session()
	tf.device('/gpu:0')


	# In[30]:


	session.run(tf.global_variables_initializer())


	# In[32]:


	for i in range(epochs):
	    traind_scores = []
	    ii = 0
	    epoch_loss = []
	    while(ii + batch_size) <= len(X_train):
	        X_batch = X_train[ii:ii+batch_size]
	        y_batch = y_train[ii:ii+batch_size]
	        
	        o, c, _ = session.run([model.logits, model.loss, model.opt], feed_dict={model.inputs:X_batch, model.targets:y_batch})
	        
	        epoch_loss.append(c)
	        traind_scores.append(o)
	        ii += batch_size
	    if (i % 3) == 0:
	        print('Epoch {}/{}'.format(i, epochs), ' Current loss: {}'.format(np.mean(epoch_loss)), ' Train Score: {}'.format(np.mean(traind_scores)))


	# In[33]:


	sup =[]
	for i in range(len(traind_scores)):
	    for j in range(len(traind_scores[i])):
	        sup.append(traind_scores[i][j])


	# In[34]:


	tests = []
	i = 0
	while i+batch_size <= len(X_test):
	    
	    o = session.run([model.logits], feed_dict={model.inputs:X_test[i:i+batch_size]})
	    i += batch_size
	    tests.append(o)


	# In[35]:


	tests_new = []
	for i in range(len(tests)):
	    for j in range(len(tests[i][0])):
	        tests_new.append(tests[i][0][j])


	# In[36]:


	test_results = []
	for i in range(df1.shape[0]-7):
	    if i >= int(scaled_df5.shape[0]*0.2+1):
	        test_results.append(tests_new[i-int(scaled_df5.shape[0]*0.2)-10])
	    else:
	        test_results.append(None)


	# In[37]:


	#plt.figure(figsize=(16, 7))
	#plt.plot(scaled_df5, label='Original data')
	#plt.plot(sup, label='Training data')
	#plt.plot(test_results, label='Testing data')
	#plt.legend()
	#plt.show()




	ans = []
	o = session.run([model.logits], feed_dict={model.inputs:X[-8:-1]})
	ans.append(o)
	print(ans)




	ans2=scaler.inverse_transform(ans)
	print(ans2)
	np.array(ans2)
	b=np.ravel(ans2)[-1]
	file=open("PRED.csv", "a")
	file.write(ticker+","+str(b)+"\n")
	file.close()


func(df1,"INTC")
func(df2,"CSCO")
func(df3,"AAPL")
func(df4,"MSFT")


