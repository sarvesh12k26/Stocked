<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Storage;
use App\stock_ent;
use App\forex_ent;
use Auth;
use GuzzleHttp\Client;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        return view('home');
    }

    public function stock_buy_form()
    {
        return view('stock.stock_form');
    }

    public function forex_buy_form()
    {
        return view('stock.forex');
    }

    public function forex_home()
    {
        return view('stock.forexhome');
    }

    public function time_convert(Request $request)
    {
        $date1=Carbon::parse($request->time_buy);
        $date2=Carbon::parse('0000-00-00 10:53:20');
        $date=$date1->diff($date2)->format('%Y-%M-%D %H:%I:%S');
        return response()->json(['success'=>true,'date'=>$date]);
    }

    public function create_stock(Request $request)
    {
        $user=new stock_ent;
        $user->stock_name=$request->get('stock_name');
        $user->price=$request->price_stk;
        $user->buy_date=$request->time_buy;
        $user->quantity=$request->quantity;
        $user->user_id=Auth::id();
        $user->save();
        return redirect('/home');
    }

    public function create_forex(Request $request)
    {
        $user=new forex_ent;
        $user->forex_name=$request->get('forex_name');
        $user->price=$request->price_frx;
        $user->buy_date=$request->time_buy;
        $user->quantity=$request->quantity;
        $user->user_id=Auth::id();
        $user->save();
        return redirect('/home');
    }
    public function get_time()
    {
        $guzzle=new Client();
        $request = $guzzle->get('https://www.alphavantage.co/query?function=TIME_SERIES_INTRADAY&symbol=NSE:GODREJCP&outputsize=compact&interval=5min&apikey=');
        $response = $request->getBody()->getContents();
        $var=json_decode($request->getBody(),true);
        $res=reset($var['Time Series (5min)']);
        dd((double)$res['4. close']);
    }

    public function stock_chart($name)
    {
        $guzzle=new Client();
        $temp=$name;
        $temp=substr($temp, 4);
        $request = $guzzle->get('http://127.0.0.1:5000/stocks/'.$temp);
        $response = $request->getBody()->getContents();
        $sent=json_decode($request->getBody(),true);
        $postweet=$sent['pos'];
        $negtweet=$sent['neg'];
        $neutraltweet=$sent['neutral'];
        return view('stock.stock_chart',compact('name','sent','postweet','negtweet','neutraltweet'));
    }

    public function stock_chart2(Request $request){
        $name=$request->input('role');
        $guzzle=new Client();
        $temp=$name;
        $request = $guzzle->get('http://127.0.0.1:5000/stocks/'.$temp);
        $response = $request->getBody()->getContents();
        $sent=json_decode($request->getBody(),true);
        $postweet=$sent['pos'];
        $negtweet=$sent['neg'];
        $neutraltweet=$sent['neutral'];
        $name='NSE:'.$name;
        return view('stock.stock_chart',compact('name','sent','postweet','negtweet','neutraltweet'));
    }

    public function forex_chart($name){
        $guzzle=new Client();
        $request = $guzzle->post('http://127.0.0.1:5000/movingaverage/'.$name);
        $response = $request->getBody()->getContents();
        $sent=json_decode($request->getBody(),true);
        $datearray=json_encode($sent['datearray']);
        $closearray=json_encode($sent['closearray']);
        $movingaverage=json_encode($sent['a']);
        return view('stock.forex_chart',compact('name','datearray','closearray','movingaverage'));

    }



}
