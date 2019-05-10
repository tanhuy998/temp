/////////////////////////  JSON setting -------------------------------------------------------
var url = 'https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=FB&interval=1min&apikey=FOB04U2PECKJLPW0';
var openPrice;
var closePrice;
var highestPrice;
var lowestPrice;

jQuery.ajax({
    url: url,
    dataType: 'json',
    contentType: "application/json",
    success: function(data){
      //console.log(data);
      var left = 5;
      
      var time = data['Meta Data']['3. Last Refreshed'];
      time = dataStart(time,39);      

      openPrice = parseFloat(data['Time Series (1min)'][time]['1. open']);
      highestPrice = parseFloat(data['Time Series (1min)'][time]['2. high']);
      lowestPrice = parseFloat(data['Time Series (1min)'][time]['3. low']);
      closePrice = parseFloat(data['Time Series (1min)'][time]['4. close']);
      
      ///Top price = current price + 0.5
      var price = parseFloat(closePrice)+2;
      
      var count = 1;
      var countCandle=0;
      var alltime;
      var intervalTime = 0;
      var markTop,markLeft,markHeight;

      //mark price
      myBuy.addEventListener("click",function(){        
        mark(markLeft,markTop,markHeight);
        var tempMarkLeft = markLeft,tempMarkTop=markTop,tempMarkHeight=markHeight;
        setInterval(function(){
          mark(tempMarkLeft,tempMarkTop,tempMarkHeight);
        },1000);        
      });      

      var animation = setInterval(flow, 0);


      function MoveCanvasHorizon(x) {
        if(x>left){             
          left=x-gap;
          var now =left;
      
          const context = canvas.getContext('2d');
          context.clearRect(0, 0, canvas.width, canvas.height);        
          
      
          for(var i = countCandle-1; i>=0;i--){               
      
            // [alltime] <> [time]
            openPrice = parseFloat(data['Time Series (1min)'][alltime]['1. open']);
            highestPrice = parseFloat(data['Time Series (1min)'][alltime]['2. high']);
            lowestPrice = parseFloat(data['Time Series (1min)'][alltime]['3. low']);
            closePrice = parseFloat(data['Time Series (1min)'][alltime]['4. close']);        
      
            var top = (price-openPrice)/0.0071;
            var height = (openPrice - closePrice)/0.0071;
            var highest = (price - highestPrice)/0.0071;
            var lowest = (price - lowestPrice)/0.0071;  
                     
      
            if(i%10==0){
              condition=0;
              drawRuler(left,alltime,price);                  
            }
            drawCandle(left,top,height,highest,lowest);                                       
            
            alltime = dataFlow(alltime,-1);
      
            left -=30;
                      
          }
          alltime = dragtime; 
          left=now;
       }
       else{
          left=x+gap;
          var now =left;
      
          const context = canvas.getContext('2d');
          context.clearRect(0, 0, canvas.width, canvas.height);
          
          
          for(var i = countCandle-1; i>=0;i--){               
      
            // [alltime] <> [time]
            openPrice = parseFloat(data['Time Series (1min)'][alltime]['1. open']);
            highestPrice = parseFloat(data['Time Series (1min)'][alltime]['2. high']);
            lowestPrice = parseFloat(data['Time Series (1min)'][alltime]['3. low']);
            closePrice = parseFloat(data['Time Series (1min)'][alltime]['4. close']);        
      
            var top = (price-openPrice)/0.0071;
            var height = (openPrice - closePrice)/0.0071;
            var highest = (price - highestPrice)/0.0071;
            var lowest = (price - lowestPrice)/0.0071;                 
      
            // templeft <> left
            if(i%10==0){
              condition=0;
              drawRuler(left,alltime,price);
            }
            drawCandle(left,top,height,highest,lowest);
      
      
             
            alltime = dataFlow(alltime,-1);
      
            left -=30;
                      
          }
          alltime = dragtime; 
          left=now;       
       }  
       
       //x=xt;
      }
      //clearInterval(animation);
      function flow(){                   

          alltime = time;

          openPrice = parseFloat(data['Time Series (1min)'][time]['1. open']);
          highestPrice = parseFloat(data['Time Series (1min)'][time]['2. high']);
          lowestPrice = parseFloat(data['Time Series (1min)'][time]['3. low']);
          closePrice = parseFloat(data['Time Series (1min)'][time]['4. close']);    

          var top = (price-openPrice)/0.0071;
          var height = (openPrice - closePrice)/0.0071;
          var highest = (price - highestPrice)/0.0071;
          var lowest = (price - lowestPrice)/0.0071;          

          drawValue(left,top,height,countCandle,closePrice);           

          if(countCandle%10==0){                       
            drawRuler(left,time,price);
          }          

          //drawCandle(left,top,height,highest,lowest);

          //

          markLeft=left;
          markTop=top;
          markHeight=height;

          left+=30;                   

          if(left<=305){
            count++;
          }      
          if(countCandle==99){            
            clearInterval(animation);
          }               
          time = dataFlow(time,1);
          countCandle++;          
                  
          //MoveCanvasHorizon(left);
        ///only 10 candle on the screen
        /*if(count == 10){

          left-=30;
          var templeft=left;

          ///// clear all canvas
          const context = canvas.getContext('2d');
          context.clearRect(0, 0, canvas.width, canvas.height);
          
          for(var i = countCandle-1; i>=0;i--){            

            templeft -=30;
            

            // [alltime] <> [time]
            openPrice = parseFloat(data['Time Series (1min)'][alltime]['1. open']);
            highestPrice = parseFloat(data['Time Series (1min)'][alltime]['2. high']);
            lowestPrice = parseFloat(data['Time Series (1min)'][alltime]['3. low']);
            closePrice = parseFloat(data['Time Series (1min)'][alltime]['4. close']);        

            var top = (price-openPrice)/0.0071;
            var height = (openPrice - closePrice)/0.0071;
            var highest = (price - highestPrice)/0.0071;
            var lowest = (price - lowestPrice)/0.0071;

            // templeft <> left
            drawCandle(templeft,top,height,highest,lowest); 
            alltime = dataFlow(alltime,-1);
                      
          }
          count--;
          
        }*/

      }      
      
      var x;
      var gap;      
      /////////////////// mouse down and move on canvas (DRAG)
      myCanvas.addEventListener("mousedown", function(e){
          x=e.clientX;          
          gap = Math.abs(x-left);        
          //clearInterval(animation);
   
         myCanvas.onmousemove = function(e) {
           var xt = e.clientX;
           var dragtime = alltime;
           if(x>left){             
              left=x-gap;
              var now =left;

              const context = canvas.getContext('2d');
              context.clearRect(0, 0, canvas.width, canvas.height);        
              

              for(var i = countCandle-1; i>=0;i--){               

                // [alltime] <> [time]
                openPrice = parseFloat(data['Time Series (1min)'][alltime]['1. open']);
                highestPrice = parseFloat(data['Time Series (1min)'][alltime]['2. high']);
                lowestPrice = parseFloat(data['Time Series (1min)'][alltime]['3. low']);
                closePrice = parseFloat(data['Time Series (1min)'][alltime]['4. close']);        

                var top = (price-openPrice)/0.0071;
                var height = (openPrice - closePrice)/0.0071;
                var highest = (price - highestPrice)/0.0071;
                var lowest = (price - lowestPrice)/0.0071;  
                         

                if(i%10==0){
                  condition=0;
                  drawRuler(left,alltime,price);                  
                }
                drawCandle(left,top,height,highest,lowest);                                       
                
                alltime = dataFlow(alltime,-1);

                left -=30;
                          
              }
              alltime = dragtime; 
              left=now;
           }
           else{
              left=x+gap;
              var now =left;

              const context = canvas.getContext('2d');
              context.clearRect(0, 0, canvas.width, canvas.height);
              
              
              for(var i = countCandle-1; i>=0;i--){               

                // [alltime] <> [time]
                openPrice = parseFloat(data['Time Series (1min)'][alltime]['1. open']);
                highestPrice = parseFloat(data['Time Series (1min)'][alltime]['2. high']);
                lowestPrice = parseFloat(data['Time Series (1min)'][alltime]['3. low']);
                closePrice = parseFloat(data['Time Series (1min)'][alltime]['4. close']);        

                var top = (price-openPrice)/0.0071;
                var height = (openPrice - closePrice)/0.0071;
                var highest = (price - highestPrice)/0.0071;
                var lowest = (price - lowestPrice)/0.0071;                 

                // templeft <> left
                if(i%10==0){
                  condition=0;
                  drawRuler(left,alltime,price);
                }
                drawCandle(left,top,height,highest,lowest);


                 
                alltime = dataFlow(alltime,-1);

                left -=30;
                          
              }
              alltime = dragtime; 
              left=now;       
           }  
           
           x=xt;
         }//function         
       });
        myCanvas.addEventListener("mouseup", function(e){
          left+=30;
           myCanvas.onmousemove = null;          
        });       
    }
});

///////// draw both ruler
var condition = 0;
function drawRuler(left,time,price){
  var c = document.getElementById("myCanvas");
  var ctx = c.getContext("2d");
  ctx.beginPath();

  //// stick vertical
  ctx.moveTo(left-1, 0);
  ctx.lineTo(left-1, 540);
  ctx.strokeStyle = "#a6a6a6";
  ctx.stroke();

  ////// time
  ctx.font="15px Arial";
  ctx.fillStyle = "#a6a6a6";
  ctx.textAlign = "center";
  ctx.fillText(time, left, 555);
  
  ////// horizontal
  
  for(var i =0;i<4;i++){

    /// price
    if(condition==0){
      if(i<3){
        ctx.clearRect(10,i*192-15,65,15);
        ctx.font="15px Arial";
        ctx.fillStyle = "#a6a6a6";
        ctx.textAlign = "left";
        ctx.fillText(parseFloat(price-(i*4/3)).toFixed(4), 10, i*192);      
      }
      else{
        condition=1;        
      }
    }
    
    ctx.moveTo(0, i*195);
    ctx.lineTo(left+300,i*195);
    ctx.strokeStyle = "#a6a6a6";
    ctx.stroke();
  }  
}

/////////////replace char using index------------
String.prototype.replaceAt=function(index, replacement) {
  return this.substr(0, index) + replacement+ this.substr(index + replacement.length);
}

///////////////// Get start time----------------
function dataStart(time,getminute){
  var str= time;
  var newtime;
  var newminute;
  if(parseInt(str.charAt(14)+str.charAt(15))<getminute){    
    newtime = (parseInt(str.charAt(11)+str.charAt(12))-2).toString();
    newminute = (parseInt(str.charAt(14)+str.charAt(15))+60-getminute).toString(); 
    if(parseInt(newtime)<10){
      newtime = "0"+newtime;  
    } 
    if(parseInt(newminute)<10){
      newminute = "0"+newminute;
    }
  }
  else{
    newtime = (parseInt(str.charAt(11)+str.charAt(12))-1).toString();
    newminute = (parseInt(str.charAt(14)+str.charAt(15))-getminute).toString(); 
    if(parseInt(newtime)<10){
      newtime = "0"+newtime;  
    } 
    if(parseInt(newminute)<10){
      newminute = "0"+newminute;
    }
  }
  
  var newStr = str.replaceAt(11, newtime);
  newStr = newStr.replaceAt(14, newminute);
  time = newStr;
  return time;
}

////////////// Minute++-----------------------
function dataFlow(time,getminute){
  var str = time;
  var newtime=(parseInt(str.charAt(11)+str.charAt(12)));
  var newminute;
  var newStr;

  newminute = (parseInt(str.charAt(14)+str.charAt(15))+getminute);

  if(newminute>=0){
    if(newminute == 60){
      if(newtime<10){////////////// hour <10
        
        newtime = "0"+(newtime+1).toString();
        newStr = str.replaceAt(11, newtime);
        newStr = newStr.replaceAt(14, "00");      
        
      }
      else{
        newtime = (newtime+1).toString();
        newStr = str.replaceAt(11, newtime);
        newStr = newStr.replaceAt(14, "00"); 
      }
    }
    else{
      if(newminute<10){
        
        newminute="0"+newminute.toString();
        newStr = str.replaceAt(14, newminute); 
      }
      else{
        newminute=newminute.toString();
        newStr = str.replaceAt(14, newminute);
      }
    }
  }  
  else{
    newtime = (newtime-1).toString();
    if(newtime < 10){
      newtime = "0"+newtime.toString();
      newStr = str.replaceAt(11, newtime); 
      newStr = str.replaceAt(14, "59"); 
    }
    else{
      newStr = str.replaceAt(11, newtime);
      newStr = newStr.replaceAt(14, "59");
    }    
  }

  time = newStr;
  return time;
}


//////////////////// Candle's setting ---------------
// create candles
/////////////////// top = open, height = close------
function drawCandle(left,top,height,highest,lowest){
  var c = document.getElementById("myCanvas");
  
  //candlestick
  var ctx = c.getContext("2d");
  ctx.beginPath();
  ctx.moveTo(left+10, highest);
  ctx.lineTo(left+10, lowest);
  
  //candle's body
  var con = c.getContext("2d");
  con.strokeStyle = "#1a1a1a";
  con.strokeRect(left, top, 20, height);

  if(height<0){
    ctx.strokeStyle = "#40ff00";//green
    con.fillStyle = "#40ff00";     
  }
  else{    
    ctx.strokeStyle = "#ff3333";//red
    con.fillStyle = "#ff3333";
  }

  con.fillRect(left, top, 20, height); 
  ctx.stroke();   
}

//////////////make canvas fit centerbar
var canvas = document.querySelector('canvas');
fitToContainer(canvas);

function fitToContainer(canvas){
  // Make it visually fill the positioned parent
  canvas.style.width ='100%';
  canvas.style.height='100%';
  //then set the internal size to match
  canvas.width  = canvas.offsetWidth;
  canvas.height = canvas.offsetHeight;
}

/// draw value on each candle
var prevtop,prevheight,prevleft;
function drawValue(left,top,height,countCandle){
  var c = document.getElementById("myCanvas");  
  
  var ctx = c.getContext("2d");
  ctx.beginPath();

  //myCanvas.onmousedown = null;
  if(countCandle!=0){
    const context = canvas.getContext('2d');          
    context.clearRect(prevleft+23, prevtop+prevheight-12, 120, 15); 
  }  
  //stick
  ctx.moveTo(left+23, top+height);
  ctx.lineTo(left+73, top+height);  
  ctx.strokeStyle = "gray";
  ctx.stroke(); 

  //curr price
  ctx.font="15px Arial";
  ctx.fillStyle = "#a6a6a6";
  ctx.textAlign = "left";
  ctx.fillText(parseFloat(closePrice).toFixed(4), left+76, top+height); 

  prevtop = top;
  prevheight = height;  
  prevleft = left;         
}

////// on click buy and sell creat a mark
function mark(left,top,height){
  var c = document.getElementById("myCanvas");  
  
  var ctx = c.getContext("2d");
  ctx.beginPath(); 

  /// draw circle
  ctx.arc(left+10, top+height, 5, 0, 2 * Math.PI);
  ctx.stroke();
  ctx.fillStyle = "yellow";
  ctx.fill();

  // draw line
  ctx.moveTo(0, top+height);
  ctx.lineTo(1200, top+height);  
  ctx.strokeStyle = "yellow";
  ctx.stroke(); 
  
}







////////////// dot


/*2 = 280px
   ?   = 1px

*/