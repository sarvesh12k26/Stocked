<?php use App\stock_ent;
use App\forex_ent;
    use GuzzleHttp\Client;
?>
@extends('layouts.app')

@section('content')
<div class="row">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Forex Equity
                </header>
                <div class="panel-body" style="display:inline-block;">
                        <a href="http://localhost:8080/codes_r1/public/forex_chart/GBP" class="btn btn-success">GBP</a>
                </div>
                <div class="panel-body" style="display:inline-block;">
                        <a href="http://localhost:8080/codes_r1/public/forex_chart/USD" class="btn btn-success">USD</a>
                </div>
                <div class="panel-body" style="display:inline-block;">
                        <a href="http://localhost:8080/codes_r1/public/forex_chart/JPY" class="btn btn-success">JPY</a>
                </div>
                <div class="panel-body" style="display:inline-block;">
                        <a href="http://localhost:8080/codes_r1/public/forex_chart/EUR" class="btn btn-success">EUR</a>
                </div>
            </section>
        </div>
</div>
<div class="col-lg-12">
                      <!--work progress start-->
                      <section class="panel">
                          <div class="panel-body progress-panel">
                              <div class="task-progress">
                                  <h1>Forex Trades</h1>
                              </div>
                          </div>
                          <table class="table table-hover personal-task">
                              <tbody>
                              <tr>
                                  <td>
                                        <span class="badge bg-important">Forex Currency</span>
                                  </td>
                                  <td>
                                      <span class="badge bg-important">Forex Quantity</span>
                                  </td>
                                  <td>
                                        <span class="badge bg-important">Current Price per unit(INR)</span>
                                  </td>
                                  <td>
                                        <span class="badge bg-important">Forex Price(At the time of buying) per unit(INR)</span>
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
                              @foreach((forex_ent::where('user_id',Auth::id())->get()) as $forex)
                              <tr>
                                    <td>
                                        <a href="{{url('/')}}/stock_chart/{{$forex->forex_name}}" target="_blank">{{$forex->forex_name}}</a>
                                    </td>
                                    <td>
                                        <span>{{$forex->quantity}}</span>
                                    </td>
                                    <?php 
                                        $guzzle=new Client();
                                        $request = $guzzle->get('https://www.alphavantage.co/query?function=FX_DAILY&from_symbol='.$forex->forex_name.'&to_symbol=INR&outputsize=compact&apikey=');
                                        $response = $request->getBody()->getContents();
                                        $var=json_decode($request->getBody(),true);
                                        @$res=reset($var['Time Series FX (Daily)']);
                                    ?>
                                    <td>
                                        <span>{{$res['4. close']}}</span>
                                    </td>
                                    <td>
                                        <span>{{$forex->price}}</span>
                                    </td>
                                    @if(($res['4. close']-$forex->price)>0)
                                        <td>
                                            <span>{{($res['4. close']-$forex->price)*$forex->quantity}}</span>
                                        </td>
                                        <td>
                                            <span>0</span>
                                        </td>
                                    @else
                                        <td>
                                            <span>0</span>
                                        </td>
                                        <td>
                                            <span>{{($res['4. close']-$forex->price)*$forex->quantity}}</span>
                                        </td>
                                    @endif
                                    <td>
                                        <span>{{$forex->buy_date}}</span>
                                    </td>
                                </tr>
                                @endforeach
                              </tbody>
                          </table>
                      </section>
                      <!--work progress end-->
                  </div>

@endsection
