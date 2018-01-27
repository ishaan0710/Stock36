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
                     
                       var result=data;
                       var c=result[0];
                       if(c=='Y')
                        { $('.listmain').html('<b>List Submitted.. Thank you<br> </b>');
                             location.reload();}
                       else
                         alert('Couldn\'t submitted.. Try again!');

                     }  
                });  
           }  
           
  });

$('.resubmit').click(function(){
     
    var regno = $(this).attr("id");

     var action = "resubmit";  
           if(confirm("Are you sure you want to resubmit?"))  
           {  
                $.ajax({  
                     url:"http://localhost/webp/boot/php/listaction.php",  
                     method:"POST",  
                     dataType:"text",  
                     data:{regno:regno,
                      action:action},  
                     success:function(data){

                           var result = $.trim(data);
                           console.log(result);
                           if(result[0]=='Y'){
                              location.reload();
                           
                              }
             
                          else if(result[0]=='N')
                            {
                                 $('.listmain').html('<b>Books Issued </b>');
                            
                            }  

              
                            
                            
                           }
                       
                       
                });  
           }  
           
  });

 
});
