


         var count = 0;
        
         var b =  document.getElementsByClassName('icon-heart2');
         for(var i in b)
         {
            b[i].onclick = function(){
                    count+=1;
                    document.getElementById('sup').innerHTML=count;
                } 
         }