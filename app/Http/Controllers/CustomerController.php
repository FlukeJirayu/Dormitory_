<?php 
namespace App\Http\Controllers;

use App\Models\CustomerModel;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
  public function index()
  {
    return view('customer');
  }
}