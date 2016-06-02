window.onload = function(){
   document.getElementById('data-agenda').onblur = function(){
      if(this.value){
          document.getElementById('hora-agenda').removeAttribute('disabled');
      }else
      {
          document.getElementById('hora-agenda').setAttribute('disabled', 'disabled');
      }
   };
};


