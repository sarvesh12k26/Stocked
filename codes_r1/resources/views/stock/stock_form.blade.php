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
                    {!!Form::open(['action'=>['HomeController@create_stock'],'method'=>'POST',"class"=>"form-horizontal tasi-form"])!!}
                            <div class="form-group">
                                <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Stocks</label>
                                <div class="col-lg-10">
                                    <select class="form-control m-bot15" id="stock_name" name="stock_name" required>
                                        <option value="">None</option>
                                        <option value="NSE:TATACHEM">NSE:TATACHEM</option>
                                        <option value="NSE:BPCL">NSE:BPCL</option>
                                        <option value="NSE:ASHOKLEY">NSE:ASHOKLEY</option>
                                        <option value="NSE:PFC">NSE:PFC</option>
                                        <option value="NSE:RELIANCE">NSE:RELIANCE</option>
                                        <option value="NSE:SUNPHARMA">NSE:SUNPHARMA</option>
                                        <option value="NSE:HDFCBANK">NSE:HDFCBANK</option>
                                        <option value="NSE:TCS">NSE:TCS</option>
                                        <option value="NSE:TECHM">NSE:TECHM</option>
                                        <option value="NSE:GODREJCP">NSE:GODREJCP</option>
                                    </select>
                                </div>
                            </div>
                
                            <div class="form-group">
                                <label class="col-sm-2 control-label col-lg-2" for="inputSuccess">Stock Quantity</label>
                                <div class="col-lg-10">
                                    <input class="form-control" type="text" name="quantity" placeholder=""  required>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="control-label col-md-3">Enter Date and Time of Buying Stock</label>
                                <div class="col-md-4">
                                    <input size="16" type="text" value="" readonly="" id="time_buy" name="time_buy" class="form_datetime form-control">
                                </div>
                            </div>
    
                            <br>
                            <div class="form-group" >
                                <label class="col-sm-2 col-lg-2 control-label">Price (INR)</label>
                                <div class="col-sm-10">
                                    <input class="form-control" id="price_stk" name="price_stk" type="text" readonly="true" placeholder="" required>
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
        var e = document.getElementById("stock_name");
        var stock_name = e.options[e.selectedIndex].value;
        var time=(document.getElementById("time_buy").value).concat(":00");
        //console.log(time);
        $.ajax({
                                        url:'http://localhost:8080/codes_r1/public/timeconv',
                                        type: 'POST',
                                        data: {time_buy:time,'_token': csrf},
                                        dataType: 'json',
                                        success: function(data) {
                                                time_new=data.date;
                                               // console.log(time_new);
                                            },
                                            fail: function(data){
                                                alert('Please try again later!');
                                            }       
                                });
                                
        $.ajax({
                                        url:'https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol='+stock_name+'&outputsize=full&interval=5min&apikey=',
                                        type: 'GET',
                                        dataType: 'json',
                                        success: function(data) {
                                                //console.log(data['Time Series (5min)'][time_new]['4. close']);
                                                //console.log(data);
                                                document.getElementById('price_stk').value=data['Time Series (5min)'][time_new]['4. close'];
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