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
    </div>

     <script>   
        var name="{!!$name!!}";
            function fetch()
            {
                chart1();
                //document.getElementById("profit").innerHTML=predict[name]+' '+'INR';
                /*
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
                                                */
            }

            function chart1(){
                var time=<?php echo $datearray;?>;
                var mov_avg=<?php echo $movingaverage;?>;
                var close_arr=<?php echo $closearray;?>;
                time.reverse();
                mov_avg.reverse();
                close_arr.reverse();
                var max=0;
                var min=0;
                for(var i=0;i<15;i++)
                {
                    if(close_arr[i]>mov_avg[i])
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
                    document.getElementById('profit_yes').style.display="block";
                }
              new Chart(document.getElementById("line-chart"), {
                type: 'line',
                data: {
                    labels: time,
                    datasets: [ { 
                        data: mov_avg,
                        label: "Close",
                        borderColor: "#8e5ea2",
                        fill: false
                    },
                    { 
                        data:  close_arr,
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