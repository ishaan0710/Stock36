$(document).ready(function(){
 //console.log("hello");
$('#login_button').click(function(){
 // console.log("hello"); 
  
  var regno=$('#regno').val();
  var password=$('#password').val();

  //console.log(regno);
  //console.log(password);
  

  if(regno !='' && password!='')
    {
      // console.log('yes');
        
         $.ajax({
              url:"http://localhost/webp/boot/php/loginaction.php",
              method:"POST",
              data: {regno:regno, password:password},
              success:function(data){
                //alert(data);
                
                 var result = $.trim(data);
                if(result==='N')
                { 
                  alert("Incorrect credentials");
                }
                else
                {
                  $('#loginModal').hide();
                  location.reload();
                    // console.log("logged");
                }
                
              }
      });
    }
   else{
    alert('Both fields are required');
   }    
  });

$('#logout').click(function(){
  //console.log("hello");
 var action="logout";
 $.ajax({
  url:"http://localhost/webp/boot/php/loginaction.php",
  method:"POST",
  data:{action:action},
  success:function(data){
    location.reload();
  }
  });

 });
});