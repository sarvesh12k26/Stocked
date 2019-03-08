<?php use App\stock_ent;
    use GuzzleHttp\Client;
?>
@extends('layouts.app')

@section('content')
<div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Search Equity
                </header>
                <div class="panel-body">
                    <form class="form-inline" target="_blank" method="POST" action="{{route('stock_chart2')}}" role="form">
                        @csrf
                        <div class="form-group">
                            <label class="sr-only" for="addrole">Enter Stock Name:</label>
                            <input type="text" class="form-control" name="role" id="addrole" placeholder="">
                        </div>
                        <button type="submit" class="btn btn-success">Add</button>
                    </form>
                </div>
            </section>
        </div>
</div>
<div class="col-lg-12">
                      <!--work progress start-->
                      <section class="panel">
                          <div class="panel-body progress-panel">
                              <div class="task-progress">
                                  <h1>Your Stocks</h1>
                              </div>
                          </div>
                          <table class="table table-hover personal-task">
                              <tbody>
                              <tr>
                                  <td>
                                        <span class="badge bg-important">Stock Name</span>
                                  </td>
                                  <td>
                                      <span class="badge bg-important">Stock Quantity</span>
                                  </td>
                                  <td>
                                        <span class="badge bg-important">Current Price per unit(INR)</span>
                                  </td>
                                  <td>
                                        <span class="badge bg-important">Stock Price(At the time of buying) per unit(INR)</span>
                                  </td>
                                  <td>
                                        <span class="badge bg-important">Profit per unit(INR)</span>
                                  </td>
                                  <td>
                                        <span class="badge bg-important">Loss per unit(INR)</span>
                                  </td>
                                  <td>
                                        <span class="badge bg-important">Date of buying</span>
                                  </td>
                              </tr>
                              @foreach((stock_ent::where('user_id',Auth::id())->get()) as $stocks)
                              <tr>
                                    <td>
                                        <a href="{{url('/')}}/stock_chart/{{$stocks->stock_name}}" target="_blank">{{$stocks->stock_name}}</a>
                                    </td>
                                    <td>
                                        <span>{{$stocks->quantity}}</span>
                                    </td>
                                    <?php 
                                        $guzzle=new Client();
                                        $request = $guzzle->get('https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol='.$stocks->stock_name.'&outputsize=compact&interval=5min&apikey=IPL2E36OEG01GVSH');
                                        $response = $request->getBody()->getContents();
                                        $var=json_decode($request->getBody(),true);
                                        @$res=reset($var['Time Series (5min)']);
                                    ?>
                                    <td>
                                        <span>{{$res['4. close']}}</span>
                                    </td>
                                    <td>
                                        <span>{{$stocks->price}}</span>
                                    </td>
                                    @if(($res['4. close']-$stocks->price)>0)
                                        <td>
                                            <span>{{round(($res['4. close']-$stocks->price)*$stocks->quantity,3)}}</span>
                                        </td>
                                        <td>
                                            <span>-</span>
                                        </td>
                                    @else
                                        <td>
                                            <span>-</span>
                                        </td>
                                        <td>
                                            <span>{{($res['4. close']-$stocks->price)*$stocks->quantity}}</span>
                                        </td>
                                    @endif
                                    <td>
                                        <span>{{$stocks->buy_date}}</span>
                                    </td>
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                      </section>
                      <!--work progress end-->
                  </div>

<div class="col-lg-6">
    <section class="panel">
        <div class="panel-body progress-panel">
            <div class="task-progress">
                <h1>Top Gainers</h1>
            </div>
        </div>
        <div>
            <table class="table table-hover personal-task">
                <tbody>
                    <tr>
                        <td>
                            <span class="badge bg-important">Stock Name</span>
                        </td>
                        <td>
                            <span class="badge bg-important">Stock Value</span>
                        </td>
                        <td>
                            <span class="badge bg-important">Gain(%)</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><a href="http://localhost:8080/codes_r1/public/stock_chart/NSE:ZEEL">Zee Entertain</a></span>
                        </td>
                        <td>
                            <span>486.35</span>
                        </td>
                        <td>
                            <span>4.21%</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><a href="http://localhost:8080/codes_r1/public/stock_chart/NSE:HINDPETRO">HPCL</a></span>
                        </td>
                        <td>
                            <span>232.70</span>
                        </td>
                        <td>
                            <span>4.19%</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><a href="http://localhost:8080/codes_r1/public/stock_chart/NSE:YESBANK">Yes Bank</a></span>
                        </td>
                        <td>
                            <span>237.60</span>
                        </td>
                        <td>
                            <span>2.79%</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><a href="http://localhost:8080/codes_r1/public/stock_chart/NSE:INDUSINDBK">IndusInd Bank</a></span>
                        </td>
                        <td>
                            <span>1514.10</span>
                        </td>
                        <td>
                            <span>2.73%</span>
                        </td>
                    </tr> 
                    <tr>
                        <td>
                            <span><a href="http://localhost:8080/codes_r1/public/stock_chart/NSE:IBULHSGFIN">IndiaBulls Hsg</a></span>
                        </td>
                        <td>
                            <span>671.90</span>
                        </td>
                        <td>
                            <span>2.54%</span>
                        </td>
                    </tr>   
                </tbody>
            </table>
        </div>
    </section>
</div>
<div class="col-lg-6">
    <section class="panel">
        <div class="panel-body progress-panel">
            <div class="task-progress">
                <h1>Top Losers</h1>
            </div>
        </div>
        <div>
            <table class="table table-hover personal-task">
                <tbody>
                    <tr>
                        <td>
                            <span class="badge bg-important">Stock Name</span>
                        </td>
                        <td>
                            <span class="badge bg-important">Stock Value</span>
                        </td>
                        <td>
                            <span class="badge bg-important">Loss(%)</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><a href="http://localhost:8080/codes_r1/public/stock_chart/NSE:BHARTIARTL">Bharti Airtel</a></span>
                        </td>
                        <td>
                            <span>307.65</span>
                        </td>
                        <td>
                            <span>-3.27%</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><a href="http://localhost:8080/codes_r1/public/stock_chart/NSE:BAJAJ-AUTO">Bajaj Auto</a></span>
                        </td>
                        <td>
                            <span>2863.50</span>
                        </td>
                        <td>
                            <span>-1.28%</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><a href="http://localhost:8080/codes_r1/public/stock_chart/NSE:AXISBANK">Axis Bank</a></span>
                        </td>
                        <td>
                            <span>702.40</span>
                        </td>
                        <td>
                            <span>-1.01%</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><a href="http://localhost:8080/codes_r1/public/stock_chart/NSE:ASIANPAINT">Asian Paints</a></span>
                        </td>
                        <td>
                            <span>1392.35</span>
                        </td>
                        <td>
                            <span>-0.91%</span>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <span><a href="http://localhost:8080/codes_r1/public/stock_chart/NSE:UPL">UPL</a></span>
                        </td>
                        <td>
                            <span>869.75</span>
                        </td>
                        <td>
                            <span>-0.89%</span>
                        </td>
                    </tr>    
                </tbody>
            </table>
        </div>
    </section>
</div>
@endsection
