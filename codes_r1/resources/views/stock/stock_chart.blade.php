@extends('layouts.app')

@section('content')
    <div class="row">
       <div class="col-lg-6">
           <div class="panel panel-default">
               <div class="panel-heading"><b>Moving Average Perfomance</b></div>
               <div class="panel-body">
                    <canvas id="line-chart" width="1000" height="600"></canvas>
                    <h3 id="profit_yes" style="display:none;">The Moving Average Index indicates buying would be profitable.</h3>
                    <h3 id="profit_no" style="display:none;">The Moving Average Index indicates selling is the most viable option.</h3>
                    
               </div>
           </div>
       </div>
        <div class="col-lg-6">
        <div class="card" style="width: 18rem;">
                <div class="card-header">
                 <b> Next Opening </b>
                </div>
                <ul class="list-group list-group-flush">
                  <li class="list-group-item"><h3 id="profit"></h3></li>
                </ul>
        </div>
        </div>
    </div>
    
    <br>
    <div class="row">
       <div class="col-lg-5">
           <div class="panel panel-default">
               <div class="panel-heading"><b>RSI INDEX Perfomance</b></div>
               <div class="panel-body">
                    <canvas id="line-chart1" width="700" height="600"></canvas>
                    <h3 id="rsi_yes" style="display:none;">The Relative Strength Index indicates selling would be profitable.</h3>
                    <h3 id="rsi_no" style="display:none;">The Relative Strength Index indicates buying is the most viable option.</h3>
                    <h3 id="rsi_mid">The Relative Strength Index provides insufficient information.</h3>
               </div>
           </div>
       </div>
       <div class="col-lg-5">
            <div class="panel panel-default">
                <div class="panel-heading"><b>Moving Average Convergence/Divergence Perfomance</b></div>
                <div class="panel-body">
                     <canvas id="line-chart2" width="700" height="600"></canvas>
                     <h3 id="macd_yes" style="display:none;">The MACD indicates BUY signal.</h3>
                     <h3 id="macd_no" style="display:none;">The MACD indicates SELL signal.</h3>
                     
                </div>
            </div>
        </div>
    </div>
    <br>
    <div class="row">
            <div class="col-lg-5"> 
                <div class="panel panel-default" >
                    <div class="panel-heading"><b>Twitter Sentiment Analysis</b></div>
                    <div class="panel-body">
                         <canvas id="line-chart-4" width="700" height="700"></canvas>
                    </div>
                </div>
            </div>
            
            <div class="col-lg-5">
                <div class="panel panel-default">
                    <div class="panel-heading"><b>DECISION-O-METER</b></div>
                    <div class="panel-body">
                         <canvas id="stacked-chart" width="700" height="200"></canvas>
                    </div>
                </div>
            </div>
         </div>

     <script>   
        var name="{!!$name!!}";
        let maxarray=[];
        let minarray=[];
        var sum_max;
        var sum_min;
        var obj={};
        var obj1={};
        var obj2={};
        var obj3={};
        var time=[];
        var time15=[];
        var open=[];
        var close=[];
        var moving_avg=[];
        var rsi=[];
        var macd_sig=[];
        var macd=[];
        var category=[];
        var values=[];
        var predict={'NSE:TCS':1922.190,'NSE:TECHM':843.341,'NSE:ASHOKLEY':82.034,'NSE:BPCL':333.967,'NSE:GODREJCP':668.864,'NSE:PFC':103.794,'NSE:HDFCBANK':2091.134,'NSE:RELIANCE':1210.517,'NSE:SUNPHARMA':426.762,'NSE:TATACHEM':566.30}
            function fetch()
            {
                //document.getElementById("profit").innerHTML=predict[name]+' '+'INR';
                $.ajax({
                                        url:'https://www.alphavantage.co/query?function=TIME_SERIES_DAILY&symbol='+name+'&outputsize=compact&apikey=',
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(data) {
                                                //console.log(data['Time Series (DAILY)'][time_new]['4. close']);
                                                obj=data['Time Series (Daily)'];
                                                //console.log(obj);
                                                for(var i in obj)
                                                {
                                                    time.push(i);
                                                    open.push(obj[i]['1. open']);
                                                    close.push(obj[i]['4. close']);
                                                }
                                                var count=0;
                                                for(var i in time)
                                                {
                                                    time15.push(time[i]);
                                                    count++;
                                                    if(count==15)
                                                    {
                                                        break;
                                                    }
                                                }
                                                var last=close[0];
                                                last=parseFloat(last);
                                                if(typeof(predict[name])!='undefined')
                                                {
                                                    //console.log(last);
                                                    //console.log(predict[name]-last);
                                                    if(parseFloat(predict[name])-last>0)
                                                    {
                                                        document.getElementById("profit").style.color="green";
                                                        document.getElementById("profit").innerHTML=predict[name]+' '+'INR'+' '+'('+parseInt(predict[name]-last)+')'+'<i class="material-icons" style="color:green;">call_made</i>';
                                                    }
                                                    else
                                                    {
                                                        document.getElementById("profit").style.color="red";
                                                        document.getElementById("profit").innerHTML=predict[name]+' '+'INR'+' '+'('+parseInt(predict[name]-last)+')'+'<i class="material-icons" style="color:red;">call_received</i>';
                                                    }
                                                }
                                                else
                                                {
                                                    var sum=0;
                                                    for(var i in time15)
                                                    {
                                                        sum+=parseFloat(obj[time15[i]]['4. close']);
                                                    }
                                                    sum=sum/15;
                                                    sum=sum.toFixed(2);
                                                    console.log(last);
                                                    console.log(sum);
                                                    if(parseFloat(sum)-last>0)
                                                    {
                                                        document.getElementById("profit").style.color="green";
                                                        document.getElementById("profit").innerHTML=sum+' '+'INR'+' '+'('+parseInt(sum-last)+')'+'<i class="material-icons" style="color:green;">call_made</i>';
                                                    }
                                                    else
                                                    {
                                                        document.getElementById("profit").style.color="red";
                                                        document.getElementById("profit").innerHTML=sum+' '+'INR'+' '+'('+parseInt(sum-last)+')'+'<i class="material-icons" style="color:red;">call_received</i>';
                                                    }

                                                }
                                                
                                                //console.log(time);
                                                //chart1();
                                            },
                                            fail: function(data){
                                                alert('Please try again later!');
                                            }       
                        }); 
                        $.ajax({
                                        url:'https://www.alphavantage.co/query?function=SMA&symbol='+name+'&interval=daily&time_period=50&series_type=close&apikey=',
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(data) {
                                                //console.log(data['Time Series (DAILY)'][time_new]['4. close']);
                                                obj1=data['Technical Analysis: SMA'];
                                                //console.log(obj);
                                                count=0;
                                                for(var i in obj1)
                                                {   
                                                    count++;
                                                    if(count<=100)
                                                    {
                                                        moving_avg.push(obj1[i]['SMA']);    
                                                    }
                                                    else
                                                    {
                                                        break;
                                                    }
                                                }
                                                //console.log(moving_avg);
                                                chart1();
                                            },
                                            fail: function(data){
                                                alert('Please try again later!');
                                            }       
                        }); 
                        $.ajax({
                                        url:'https://www.alphavantage.co/query?function=RSI&symbol='+name+'&interval=daily&time_period=14&series_type=open&apikey=',
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(data) {
                                                //console.log(data['Time Series (DAILY)'][time_new]['4. close']);
                                                obj2=data['Technical Analysis: RSI'];
                                                //console.log(obj2);
                                                count=0;
                                                for(var i in obj2)
                                                {   
                                                    count++;
                                                    if(count<=100)
                                                    {
                                                        rsi.push(obj2[i]['RSI']);    
                                                    }
                                                    else
                                                    {
                                                        break;
                                                    }
                                                }
                                                //console.log(rsi);
                                                chart2();
                                            },
                                            fail: function(data){
                                                alert('Please try again later!');
                                            }       
                        });
                        $.ajax({
                                        url:'https://www.alphavantage.co/query?function=MACD&symbol='+name+'&interval=daily&time_period=14&series_type=close&apikey=',
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(data) {
                                                //console.log(data['Time Series (DAILY)'][time_new]['4. close']);
                                                obj3=data['Technical Analysis: MACD'];
                                                //console.log(obj3);
                                                count=0;
                                                for(var i in obj3)
                                                {   
                                                    count++;
                                                    if(count<=100)
                                                    {
                                                        macd.push(obj3[i]['MACD']);
                                                        macd_sig.push(obj3[i]['MACD_Signal']);    
                                                    }
                                                    else
                                                    {
                                                        break;
                                                    }
                                                }
                                                //console.log(macd);
                                                //console.log(macd_sig);
                                                chart3();
                                                sum_max=maxarray[0]+maxarray[1]+maxarray[2];
                                                sum_min=minarray[0]+minarray[1]+minarray[2];
                                                //console.log(sum_max);
                                               // console.log(sum_min);
                                                chart4();
                                                chart5();
                                            },
                                            fail: function(data){
                                                alert('Please try again later!');
                                            }       
                        });

            }

            function chart1(){
              //console.log(time);
              //console.log(open);
              //console.log(close);  
              time.reverse();
              open.reverse();
              close.reverse();
              moving_avg.reverse();
              var max=0;
              var min=0;
              for(i in time15)
              {
                  //console.log((time15[i]).substring(0,11));
                  if(parseInt(obj[time15[i]]['4. close'])>=parseInt(obj1[(time15[i]).substring(0,11)]['SMA']))
                  {
                      max++;
                  }
                  else
                  {
                      min++;
                  }
              }
              if(max>min)
              {
                  document.getElementById('profit_yes').style.display="block";
              }
              else
              {
                  document.getElementById('profit_no').style.display="block";
              }
              maxarray.push(max);
              minarray.push(min);
              
              new Chart(document.getElementById("line-chart"), {
                type: 'line',
                data: {
                    labels: time,
                    datasets: [{ 
                        data: open,
                        label: "Open",
                        borderColor: "#3e95cd",
                        fill: false
                    }, { 
                        data: close,
                        label: "Close",
                        borderColor: "#8e5ea2",
                        fill: false
                    },
                    { 
                        data: moving_avg,
                        label: "Moving_Average",
                        borderColor: "#3cba9f",
                        fill: false
                    }
                    ]
                },
                options: {
                    title: {
                    display: true,
                    text: 'Open|Close vs Day'
                    }
                }
                });
            }

            function chart2(){
              rsi.reverse();
              var max=0;
              var min=0;
              for(i in time15)
              {
                  //console.log((time15[i]).substring(0,11));
                  if(parseInt(obj2[(time15[i]).substring(0,11)]['RSI'])>=70)
                  {
                      max++;
                  }
                  else if(parseInt(obj2[(time15[i]).substring(0,11)]['RSI'])<=30)
                  {
                      min++;
                  }
              }
              maxarray.push(max);minarray.push(min);
              if(max>min)
              {
                  document.getElementById('rsi_mid').style.display="none";
                  document.getElementById('rsi_yes').style.display="block";
              }
              else if(min>max)
              {
                  document.getElementById('rsi_mid').style.display="none";
                  document.getElementById('rsi_no').style.display="block";
              }
              new Chart(document.getElementById("line-chart1"), {
                type: 'line',
                data: {
                    labels: time,
                    datasets: [{ 
                        data: rsi,
                        label: "RSI",
                        borderColor: "#3e95cd",
                        fill: false
                    }
                    ]
                },
                options: {
                    title: {
                    display: true,
                    text: 'RSI vs Day'
                    }
                }
                });
            }

            function chart3(){
              macd.reverse();
              macd_sig.reverse();  
              var max=0;
              var min=0;
              for(i in time15)
              {
                  if(parseFloat(obj3[(time15[i]).substring(0,11)]['MACD'])>parseFloat(obj3[(time15[i]).substring(0,11)]['MACD_Signal']))
                  {
                      max++;
                  }
                  else
                  {
                      min++;
                  }
              }
              maxarray.push(max);minarray.push(min);
              if(max>min)
              {
                  document.getElementById('macd_yes').style.display="block";
              }
              else
              {
                  document.getElementById('macd_no').style.display="block";
              }
              new Chart(document.getElementById("line-chart2"), {
                type: 'line',
                data: {
                    labels: time,
                    datasets: [{ 
                        data: macd,
                        label: "MACD",
                        borderColor: "#3e95cd",
                        fill: false
                    }, { 
                        data: macd_sig,
                        label: "MACD-SIGNAL",
                        borderColor: "#8e5ea2",
                        fill: false
                    }
                    ]
                },
                options: {
                    title: {
                    display: true,
                    text: 'MACD|MACD-SIGNAL vs Day'
                    }
                }
                });
            }

            function chart4(){
                new Chart(document.getElementById("line-chart-4"), {
                type: 'bar',
                data: {
                    labels: ['pos','neutral','neg'],
                    datasets: [{ 
                        data:[<?php echo $postweet?>, <?php echo $neutraltweet?>, <?php echo $negtweet?>],
                        label: "Tweets",
                        borderColor: "#002d23",
                        fillOpacity: .7,
                        fill: true
                    }]
                },
                options: {
                    title: {
                    display: true,
                    text: 'MACD|MACD-SIGNAL vs Day'
                    }
                }
                });
              
            }
            function chart5(){
                new Chart(document.getElementById("stacked-chart"), {
                    type: 'horizontalBar',
                    data: {
                        labels:['Risk Level'],
                        datasets: [
                                {
                                    label: 'SELL',
                                    data: [sum_max],
                                    backgroundColor: '#36ba0e', // green
                                    fill: false
                                },
                                {
                                    label: 'HOLD',
                                    data: [(sum_max+sum_min)-(Math.abs(sum_max-sum_min))],
                                    backgroundColor: '#09627a', // yellow
                                    fill: false
                                },
                                {
                                    label: 'BUY',
                                    data: [sum_min],
                                    backgroundColor: '#ce1414', // red
                                    fill: false
                                }
                                ]
                    },
                    options: {
                        scales: {
                            xAxes: [{
                                stacked: true,
                                ticks: {
                                beginAtZero: true,
                                steps: 10,
                                stepValue: 5,
                                max: sum_max+sum_min+(sum_max+sum_min)-(Math.abs(sum_max-sum_min)),
                                }
                            }],
                            yAxes: [{
                                stacked: true
                            }]
                        }
                    }
                });

            }

                function start() {
                    fetch();
                    //chart1();
                }
                window.onload = start;
        </script>




@endsection

@section('foot-content')
    {{--<script src="{{asset('js/common-scripts.js')}}"></script>--}}
    <script src="{{asset('js/jquery-ui-1.9.2.custom.min.js')}}"></script>
    <script src="{{asset('js/jquery-migrate-1.2.1.min.js')}}"></script>
    <script src="{{asset('js/jquery.sparkline.js')}}" type="text/javascript"></script>
    <script src="{{asset('assets/jquery-easy-pie-chart/jquery.easy-pie-chart.js')}}"></script>
    <script src="{{asset('js/owl.carousel.js')}}" ></script>
    <script src="{{asset('assets/chart-master/Chart.js')}}"></script>

    <script src="{{asset('js/jquery.customSelect.min.js')}}" ></script>
    <script src="{{asset('js/sparkline-chart.js')}}"></script>
    <script src="{{asset('js/easy-pie-chart.js')}}"></script>
    <script src="{{asset('js/count.js')}}"></script>
    {{--<script src="{{asset('js/all-chartjs.js')}}"></script>--}}
    <script src="{{asset('js/Chart.js')}}"></script>

    <script type="text/javascript" src="{{asset('assets/select2/js/select2.min.js')}}"></script>

@endsection