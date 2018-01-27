$(document).ready(function(){
  
  $('.delete').click(function(){
     
    var bid = $(this).attr("id");

     var action = "remove";  
           if(confirm("Are you sure you want to remove this book?"))  
           {  
                $.ajax({  
                     url:"http://localhost/webp/boot/php/listaction.php",  
                     method:"POST",  
                     dataType:"text",  
                     data:{bid:bid, action:action},  
                     success:function(data){  
                       $('.listmain').html(data);  
                          
                     } 
                });  
           }  
           else  
           {  
                return false;  
           }  
  });

  $('#submit').click(function(){
     
    var bid = $(this).attr("id");

     var action = "submit";  
           if(confirm("Are you sure you want to submit?"))  
           {  
                $.ajax({  
                     url:"http://localhost/webp/boot/php/listaction.php",  
                     method:"POST",  
                     dataType:"text",  
                     data:{action:action},  
                     success:function(data){  
                         var result = $.trim(data);
                        alert(result);
                       if(result[0]=='Y')
                         // $('.listmain').html('List submitted');
                        else
                       // alert('Not submitted');  
                     }  
                });  
           }  
           else  
           {  
                return false;  
           }  
  });

  var book="book";
var notice="notice";
$('#newbooks').html('');
$('#notices').html('');

$.ajax({
url:"http://localhost/webp/boot/php/noticesandbooksaction.php",
method:"POST",
data:{iid:book},
success:function(data){
  $('#newbooks').html(data);  
}
});

$.ajax({
url:"http://localhost/webp/boot/php/noticesandbooksaction.php",
method:"POST",
data:{iid:notice},
success:function(data){
  $('#notices').html(data);  
}
});




  
$('#searchtext').keyup(function(){
      var txt = $(this).val();
      
      if(txt!='')
      {
        $.ajax({
             url:"http://localhost/webp/boot/php/searchaction.php",
             method:"POST",
             data:{search:txt},
             dataType:"text",

             success:function(data){
              $('#result').html(data);
             }
  
        });
      }

      else{
        $('#result').html('');
      }


 });



 
});
