<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataBaseCRUD;
use App\Models\UploadFile;

class customerController extends Controller
{
    public function index()
    {
        return view('indexCustomer');
    }

    public function create()
    {
        return view('formCustomer');
    }

    public function store(Request $request)
    {
        $uniqID     = 'Cust-'.hash('crc32', $request->inputEmail);
        $dataCustomer   = [
            'uniqID_Customer'   => $uniqID,
            'email_customer'    => $request->inputEmail,
            'nama_customer'     => $request->inputName,
            'bod_customer'      => $request->inputBOD,
            'phone_customer'    => $request->inputPhone
        ];
        $dataAlamat     = [
            'id_customers'  => $uniqID,
            'alamat'        => $request->inputAddress
        ];
        $dataRekening   = [
            'id_customers'      => $uniqID,
            'nomor_rekening'    => $request->inputRekening,
            'bank_rekening'     => $request->inputBank
        ];
        $where['data'][]=array(
			'column'    =>'email_customer',
			'param'		=> $request->inputEmail
		);
        $check  =   DataBaseCRUD::checkData('customer',$where);
        if ($check==true) {
            $response       =   array('status' => 400,'message' => 'Data is store.','success' => 'Error','location' => '/customer');
        } 
        else {
            if ($request->file('fileImg')!==NULL) {
                $namefile   = $uniqID.'.'.$request->file('fileImg')->extension();
                $uploadFile     =   UploadFile::upload($request->file('fileImg'),$namefile);
                $dataImage      = [
                    'id_customers'      => $uniqID,
                    'file_location'     => 'storage/img',
                    'file_image'        => $namefile
                ];
                $insertImage    =   DataBaseCRUD::insertData('customers_image',$dataImage);
            }
            $insertCustomer =   DataBaseCRUD::insertData('customer',$dataCustomer);
            $insertAlamat   =   DataBaseCRUD::insertData('alamat',$dataAlamat);
            $insertRekening =   DataBaseCRUD::insertData('rekening',$dataRekening);
            $response       =   array('status' => 200,'message' => 'Save Success.','success' => 'OK','location' => '/customer');
        }
        echo json_encode($response);
    }

    public function show(Request $request)
    {
        //SELECT
        $select =   'customer.uniqID_Customer,customer.email_customer,customer.nama_customer,alamat.alamat,customer.phone_customer,rekening.bank_rekening';
        //TABLE
        $table  =   'customer';
        //LIMIT
        $limit = array(
            'start'  => $request->input('start'),//Input::get('start'),
            'finish' => $request->input('length')//Input::get('length')
        );
        //WHERE LIKE
        $where_like['data'][] = array(
            'column' => 'customer.nama_customer,customer.email_customer,customer.phone_customer,alamat.alamat,rekening.bank_rekening',
            'param'	 => $request->input('search[value]')//Input::get('search[value]')
        );
        //ORDER
        $index_order = $request->input('order[0][column]');//Input::get('order[0][column]');
        $order['data'][] = array(
            'column' => $request->input('columns['.$index_order.'][name]'),//Input::get('columns['.$index_order.'][name]'),
            'type'	 => $request->input('order[0][dir]')//Input::get('order[0][dir]')
        );
        //JOIN
        $join['data'][] = array(
            'table'         => 'alamat',
            'IDprimary'     => 'customer.uniqID_Customer',
            'IDsecondary'	=> 'alamat.id_customers'
        );
        $join['data'][] = array(
            'table'         => 'rekening',
            'IDprimary'     => 'customer.uniqID_Customer',
            'IDsecondary'	=> 'rekening.id_customers'
        );
        //WHERE
    	$where['data'][]=array(
			'column'    =>'customer.status_delete',
			'param'		=> 0
		);
    	//where2
    	$where2     =   NULL;
    	// group by
    	$group_by   =   NULL;
        $columns    =   array();
		$query_total  = DataBaseCRUD::tableData($select,$table,NULL,NULL,NULL,$join,$where,$where2,$group_by);
		$query_filter = DataBaseCRUD::tableData($select,$table,NULL,$where_like,$order,$join,$where,$where2,$group_by);
		$query        = DataBaseCRUD::tableData($select,$table,$limit,$where_like,$order,$join,$where,$where2,$group_by);
        if ($query<>false) {
			$no = $limit['start']+1;
		    foreach ($query as $val) {
		        if ($query_total->count()>0) {
                    $btn    =   '<div class="dropdown d-inline-block">
                                    <button type="button" aria-haspopup="true" aria-expanded="false" data-toggle="dropdown" class="mb-2 mr-2 dropdown-toggle btn btn-primary btn-block">Pilih</button>
                                    <div tabindex="-1" role="menu" aria-hidden="true" class="dropdown-menu-hover-link dropdown-menu-right dropdown-menu-rounded dropdown-menu">
                                        <button type="button" tabindex="0" class="dropdown-item text-warning btn-update" data-id="'.$val->uniqID_Customer.'" data-action="editCustomer">
                                            <i class="dropdown-icon fa fa-pencil"></i><span>&nbsp;Update</span>
                                        </button>
                                        <button type="button" tabindex="0" class="dropdown-item text-danger btn-delete" data-id="'.$val->uniqID_Customer.'" data-action="deleteCustomer">
                                            <i class="dropdown-icon fa fa-trash"></i><span>&nbsp;Delete</span>
                                        </button>
                                    </div>
                                </div>';
                    // coloumn    
                        $response['data'][] = array(
                            '#'         =>  $no,
        			        'Email'     =>  strtolower($val->email_customer),
        					'Name'      =>  ucwords($val->nama_customer),
        					'Address'   =>  ucwords($val->alamat),
        					'Phone'     =>  ucwords($val->phone_customer),
                            'Bank'      =>  ucwords($val->bank_rekening),
        					'Action'    =>  $btn,
        				);
        			// coloumn
        				foreach($response['data'][0] as $column=>$relativeValue) {
                            $columns[] = array(
                                "name"=>$column,
                                "data"=>$column
                            );
                        }
                        $response['columns'] = array_unique($columns, SORT_REGULAR);
		            $no++;	
				}		
		    }
		}
		$response['recordsTotal']       = 0;
		if ($query_total<>false) {
			$response['recordsTotal']   = $query_total->count();
		}
		$response['recordsFiltered']    = 0;
		if ($query_filter<>false) {
			$response['recordsFiltered']= $query_filter->count();
		}
		$response['message']            = 'Success Created Data';
        $json   =   array('status' => 200,'success' => 'OK','response' => $response);
        echo json_encode($json);
    }

    public function edit(Request $request)
    {
        //SELECT
        $select =   '*';
        //TABLE
        $table  =   'customer';
        //JOIN
        $join['data'][] = array(
            'table'         => 'alamat',
            'IDprimary'     => 'customer.uniqID_Customer',
            'IDsecondary'	=> 'alamat.id_customers'
        );
        $join['data'][] = array(
            'table'         => 'rekening',
            'IDprimary'     => 'customer.uniqID_Customer',
            'IDsecondary'	=> 'rekening.id_customers'
        );
        $join['data'][] = array(
            'table'         => 'customers_image',
            'IDprimary'     => 'customer.uniqID_Customer',
            'IDsecondary'	=> 'customers_image.id_customers'
        );
        //WHERE
    	$where['data'][]=array(
			'column'    =>'customer.uniqID_Customer',
			'param'		=> $request->dataID
		);

        $query =   DataBaseCRUD::showData($select,$table,$join,$where);
        if ($query<>false) {
            $response   =   array('status' => 200,'message' => 'View Success.','success' => 'OK','data'=>$query);
        }
        echo json_encode($response);
    }

    public function update(Request $request)
    {
        $dataCustomer   = [
            'email_customer'    => $request->inputEmail,
            'nama_customer'     => $request->inputName,
            'bod_customer'      => $request->inputBOD,
            'phone_customer'    => $request->inputPhone
        ];

        $dataAlamat     = [
            'alamat'        => $request->inputAddress
        ];

        $dataRekening   = [
            'nomor_rekening'    => $request->inputRekening,
            'bank_rekening'     => $request->inputBank
        ];
        
        $where['data'][]=array(
			'column'    =>'id_customers',
			'param'		=> $request->inputIDCustomer
		);

        $whereCustomer['data'][]=array(
			'column'    =>'uniqID_Customer',
			'param'		=> $request->inputIDCustomer
		);

        if ($request->file('fileImg')!==NULL) {
            $namefile   = $request->inputIDCustomer.'.'.$request->file('fileImg')->extension();
            $uploadFile     =   UploadFile::upload($request->file('fileImg'),$namefile);
            $dataImage      = [
                'file_location'     => 'storage/img',
                'file_image'        => $namefile
            ];
            $updateImage    =   DataBaseCRUD::updateData('customers_image',$where,$dataImage);
        }

        $updateCustomer =   DataBaseCRUD::updateData('customer',$whereCustomer,$dataCustomer);
        $updateAlamat   =   DataBaseCRUD::updateData('alamat',$where,$dataAlamat);
        $updateRekening =   DataBaseCRUD::updateData('rekening',$where,$dataRekening);
        $response       =   array('status' => 200,'message' => 'Save Success.','success' => 'OK','location' => '/customer');
        echo json_encode($response);
    }

    public function delete(Request $request)
    {
        $dataCustomer   = [
            'status_delete'    => 1
        ];

        $whereCustomer['data'][]=array(
			'column'    =>'uniqID_Customer',
			'param'		=> $request->dataID
		);

        $deleteCustomer =   DataBaseCRUD::updateData('customer',$whereCustomer,$dataCustomer);
        $response       =   array('status' => 200,'message' => 'Delete Success.','success' => 'OK','location' => '/customer');
        echo json_encode($response);        
    }
}