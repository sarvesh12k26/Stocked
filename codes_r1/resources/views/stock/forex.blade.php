@extends('layouts.app')

@section('content')
<!---->
<div class="row" style="width:1000px; margin-left: 150px;">
        <div class="col-lg-12">
            <section class="panel">
                <header class="panel-heading">
                    Stock Details
                </header>
                <div class="panel-body">
                    {!!Form::open(['action'=>['HomeController@create_forex'],'method'=>'POST',"class"=>"form-horizontal tasi-form"])!!}
                            <div class="form-group">
                                <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Forex</label>
                                <div class="col-lg-10">
                                    <select class="form-control m-bot15" id="forex_name" name="forex_name" required>
                                        <option value="">None</option>
                                        <option value="USD">USD</option>
                                        <option value="GBP">GBP</option>
                                        <option value="JPY">JPY</option>
                                        <option value="EUR">EUR</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="form-group">
                                <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Forex Quantity</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" name="quantity" placeholder=""  required>
                                </div>
                            </div>

                            <div class="form-group">
                                  <label class="control-label col-md-3">Enter Date of Buying Foreign Currency</label>
                                  <div class="col-md-3 col-xs-11">

                                      <div data-date-viewmode="years" data-date-format="yyyy-mm-dd" data-date="" class="input-append date dpYears">
                                          <input type="text" readonly="" value="" size="16" id="time_buy" name="time_buy" class="form-control">
                                              <span class="input-group-btn add-on">
                                                <button class="btn btn-danger" type="button"><i class="fa fa-calendar"></i></button>
                                              </span>
                                      </div>
                                      <span class="help-block">Select Date</span>
                                  </div>
                              </div>

                            <br>
                            <div class="form-group" >
                                <label class="col-sm-2 col-lg-2 control-label">Price (INR)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="price_frx" name="price_frx" type="text" readonly="true" placeholder="" required>
                                </div>
                            </div> 
                            <br>
                            <div>
                                <button type="submit" id="sub" class="btn btn-success" style="display:none;">Submit</button>
                                <button type="button" id="pric" class="btn btn-success" onclick="price()">Check Price</button>
                            </div>  
                    {!!Form::close()!!}
                </div>
            </section>
        </div>
    </div>

<script>
    var csrf = $('meta[name="csrf-token"]').attr('content');
    function price()
    {   var time_new="";
        var e = document.getElementById("forex_name");
        var forex_name = e.options[e.selectedIndex].value;
        var time=(document.getElementById("time_buy").value);
        $.ajax({
                                        url:'https://www.alphavantage.co/query?function=FX_DAILY&from_symbol='+forex_name+'&to_symbol=INR&apikey=',
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(data) {
                                                //console.log(data['Time Series (5min)'][time_new]['4. close']);
                                                //console.log(data);
                                                document.getElementById('price_frx').value=data['Time Series FX (Daily)'][time]['4. close'];
                                                document.getElementById('sub').style.display="block";
                                                document.getElementById('pric').style.display="none";
                                            },
                                            fail: function(data){
                                                alert('Please try again later!');
                                            }       
                                });
                    
    }
</script>

@endsection