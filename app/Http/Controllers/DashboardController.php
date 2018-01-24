<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Category;
use App\Coupon;
use App\Invoice;
use App\Notification;
use App\Transaction;

class DashboardController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
        $this->middleware('admin');
    }

    public function index(){
        $overview = \DB::select("select user,item,transaction from
        (select count(*) user from users where level='0') users,
        (select count(*) item from items) items,
        (select count(*) transaction from transactions where status!='saved') transactions")[0];
        $str   = @file_get_contents('/proc/uptime');
        $num   = floatval($str);
        $secs  = fmod($num, 60); $num = intdiv($num, 60);
        $mins  = $num % 60;      $num = intdiv($num, 60);
        $hours = $num % 24;      $num = intdiv($num, 24);
        $days  = $num;
        $overview->uptime = "{$days}d{$hours}h{$mins}m";
        $linkName = 0;
        $subLink = 0;
        return view('dashboard.index',compact('linkName','subLink','overview'));
    }

    public function dashboard($dash, $subdash = 0){
        $data = false;
        switch($dash){
            case "kategori":
                switch($subdash){
                    case "statistik":
                        $data = \App\Category::with('item')->get();
                        break;
                }
                break;
            case "transaksi":
                $data = Invoice::where('status','wait')->where('paymentInfo','!=','null')->with('user')->orderBy('updated_at','desc')->get();
                break;
            case "kupon":
                if($subdash == 'tampil'){
                    $data = Coupon::all();
                }
                break;
            case "pengaturan":
                switch($subdash){
                    case "slider":
                        $data = \DB::table('sliders')->get();
                        break;
                }
                break;
        }
        return view('dashboard.index',['linkName' => $dash,'subLink' => $subdash, 'data' => $data]);
    }

    public function addCategory(){
        $this->validate(request(),[
            'name' => 'required|min:2|unique:categories,name'
        ]);
        Category::create(request()->all());

        session()->flash('cm','Kategori telah ditambahkan');

        return redirect()->route('board',['board' => 'kategori','subboard' => 'statistik']);
    }

    public function addCoupon(){
        $this->validate(request(),[
            'code' => 'required|min:3|max:10|unique:coupons',
            'minimum' => 'required',
            'discount' => 'required',
            'maximum' => 'required'
        ]);
        Coupon::create(request()->all());

        session()->flash('cm','Kupon telah ditambahkan');

        return redirect()->route('board', ['board' => 'coupon', 'subboard' => 'tampil']);
    }

    public function confirminvoice(Invoice $invoice){
        $invoice->load('transactions.seller');
        $insert = [];
        $transactionIds = [];
        foreach($invoice->transactions as $transaction){
            $transactionIds[] = $transaction->id;

            $data = [
                'disposal' => $transaction->id
            ];

            $notification = new Notification();
            $notification->user_id = $transaction->seller->id;
            $notification->text = 'Kamu mendapatkan pesanan baru';
            $notification->action = 'disposal.show';
            $notification->data = json_encode($data);
            $notification->save();
        }

        Transaction::whereIn('id',$transactionIds)->update([
            'status' => 'paid',
        ]);

        // Notification::create($insert);


        $invoice->status = 'paid';
        $invoice->save();

        session()->flash('cm', 'Transaksi berhasil dikonfirmasi');

        return back();
    }

    public function rejectinvoice(Invoice $invoice){
        $invoice->status = 'reject';
        $invoice->save();

        session()->flash('cm', 'Transaksi berhasil ditolak');

        return back();
    }

    public function storeSlider(){
        $this->validate(request(),[
            'photo' => 'required|image'
        ]);
        \DB::table('sliders')->insert([
            'filename' => request('photo')->store('/public/sliders')
        ]);

        return redirect()->route('board',['board' => 'pengaturan','subboard' => 'slider'])
        ->with('cm','Slider berhasil disimpan');
    }

    public function destroySlider($slider){
        $data = \DB::table('sliders')->where('id',$slider);
        \Storage::delete($data->first()->filename);
        $data->delete();
        return back()->with('cm','Slider berhasil dihapus');
    }

    public function destroyCategory(Category $category){
        $category->item()->delete();
        $category->delete();
        return back()->with('cm','Kategori berhasil dihapus');
    }

    public function destroyCoupon(Coupon $coupon){
        $coupon->delete();
        return back()->with('cm','Kupon berhasil dihapus');
    }
}
