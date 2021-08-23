@extends('layouts.app')
@section("title") {{__('storeDashboard.ipPageTitle')}}
@endsection


@section('styles')

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.5.2/animate.min.css">


@endsection
@section('content')
 <style>
  

.card .card-header {
  padding-top: 10px;
    background: #F4F5F7;
   
}


.row {
     margin-right: 0px;
    margin-left: 0px;
}


table.dataTable tbody td {
    word-break: break-word;
    vertical-align: middle;
}



div.dataTables_wrapper .select2-selection--single {
    background-color: #fff;
    border: 1px solid #e3e6ef;
    border-radius: 4px;
    height: 48px;
    width: 100px;
    display: flex;
    align-items: center;
} 

div.dataTables_wrapper div.dataTables_filter {
    text-align: right;
    float: right;
}

.userDatatable table {
    border-bottom: 0px solid #f1f2f6;
  
}

div.dataTables_wrapper div.dataTables_filter input {
    margin-left: .5em;
    display: inline-block;
    width: auto;
    height: 48px;
    width: 250px;
    font-size: 14px;
    padding: 20px;
}


table.dataTable tbody td {
    word-break: break-word;
    vertical-align: middle;
}
table td{
       word-wrap:break-word;
    }



        </style>
 
 

 <div class="contents">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="shop-breadcrumb">
                    <div class="breadcrumb-main">
                        <h4 class="text-capitalize breadcrumb-title">Minhas Lojas</h4>
                        <div class="breadcrumb-action justify-content-center flex-wrap">
                            {{-- <div class="action-btn">
                                <div class="form-group mb-0">
                                    <div class="input-container icon-left position-relative">
                                            <span class="input-icon icon-left">
                                                <span data-feather="calendar"></span>
                                            </span>
                                        <input type="text" class="form-control form-control-default date-ranger" name="date-ranger" placeholder="Oct 30, 2019 - Nov 30, 2019">
                                        <span class="input-icon icon-right">
                                                <span data-feather="chevron-down"></span>
                                            </span>
                                    </div>
                                </div>
                            </div> --}}
                          {{--   <div class="dropdown action-btn">
                                <button class="btn btn-sm btn-default btn-white dropdown-toggle" type="button" id="dropdownMenu2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-download"></i> Export
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu2">
                                    <span class="dropdown-item">Export With</span>
                                    <div class="dropdown-divider"></div>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-print"></i> Printer</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-file-pdf"></i> PDF</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-file-text"></i> Google Sheets</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-file-excel"></i> Excel (XLSX)</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-file-csv"></i> CSV</a>
                                </div>
                            </div>
                            <div class="dropdown action-btn">
                                <button class="btn btn-sm btn-default btn-white dropdown-toggle" type="button" id="dropdownMenu3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="la la-share"></i> Share
                                </button>
                                <div class="dropdown-menu" aria-labelledby="dropdownMenu3">
                                    <span class="dropdown-item">Share Link</span>
                                    <div class="dropdown-divider"></div>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-facebook"></i> Facebook</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-twitter"></i> Twitter</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-google"></i> Google</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-feed"></i> Feed</a>
                                    <a href="" class="dropdown-item">
                                        <i class="la la-instagram"></i> Instagram</a>
                                </div>
                            </div>
                            <div class="action-btn">
                                <a href="" class="btn btn-sm btn-primary btn-add">
                                    <i class="la la-plus"></i> Add New</a>
                            </div> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <div class="userDatatable orderDatatable global-shadow border py-30 px-sm-30 px-20 bg-white radius-xl w-100 mb-30">
                    <div class="project-top-wrapper d-flex justify-content-between flex-wrap mb-25 mt-n10">
                        <div class="d-flex align-items-center flex-wrap justify-content-center">
                            {{-- <div class="project-search order-search  global-shadow mt-10">
                                <form action="/" class="order-search__form">
                                    <span data-feather="search"></span>
                                    <input class="form-control mr-sm-2 border-0 box-shadow-none" type="search" placeholder="Pesquisar" aria-label="Pesquisar">
                                </form>
                            </div><!-- End: .project-search --> --}}
                             <div class="project-category d-flex align-items-center  mt-xl-10 mt-15">
                                <p class="fs-14 color-gray text-capitalize mb-10 mb-md-0  mr-10">Status :</p>
                                <div class="project-tap order-project-tap global-shadow">
                                    <ul class="nav px-1" id="ap-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('admin.stores') ? 'active' : ''}}" href="{{ route('admin.stores') }}">Todas</a>
                                        </li>
                                       {{--  <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.couponsNonExpired') ? 'active' : ''}}" href="{{ route('panel.couponsNonExpired') }}">Ativos</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('panel.couponsExpired') ? 'active' : ''}}" href="{{ route('panel.couponsExpired') }}" >Vencidos
                                                </a>
                                        </li> --}}
                                        <li class="nav-item">
                                            <a class="nav-link {{ Route::is('admin.storesDeleted') ? 'active' : ''}}" href="{{ route('admin.storesDeleted') }}">Lixeira</a>
                                        </li>
                                    </ul>
                                </div>
                            </div><!-- End: .project-category --> 
                        </div><!-- End: .d-flex -->
                        <div class="content-center mt-10">
                            <div class="button-group m-0 mt-xl-0 mt-sm-10 order-button-group">
                     
                                <button type="button" class="btn btn-primary" 
                                data-toggle="modal" data-target="#addNewAddonModal">
                                <i class="la la-plus"></i>Adicionar Loja</button>

                                {{-- <a class="btn btn-primary btn-labeled btn-labeled-left" href="{{route('restaurant.newAddonCategory')}}">
                                    <b><i class="icon-plus2"></i></b>
                                    Adicionar Novo Grupo
                                </a> --}}
                            </div>
                        </div><!-- End: .content-center -->
                    </div><!-- End: .project-top-wrapper -->
                    <div class="tab-content" id="ap-tabContent">
                        <div class="tab-pane fade show active" id="ap-overview" role="tabpanel" aria-labelledby="ap-overview-tab">
                            
                            <!-- Start Table Responsive -->
                            <div class="table-responsive">
                                <table class="table mb-0 table-hover table-borderless border-0"  id="itemsDataTable" >
                                    <thead>
                                        <tr class="userDatatable-header">
                                        
                                           
                                          {{--   <th><span class="userDatatable-title">Logo</span></th> --}}
                                            <th><span class="userDatatable-title">Nome da Loja</span></th>
                                            <th><span class="userDatatable-title">Fazer Login</span></th>
                                         {{--    <th style="width: 15%"><span class="userDatatable-title">Vendedores</span></th> --}}
                                          
                                            <th style="width: 15%"><span class="userDatatable-title">Adicionado em:</span></th>
                                            <th class="text-center" style="width: 10%;"><i class="
                                                icon-circle-down2"></i><span class="userDatatable-title">Ações</span></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($restaurants as $restaurant)
                                        <tr class="item">
                                            
                                           {{--  <td><img src="{{substr(url("/"), 0, strrpos(url("/"), '/'))}}{{ $restaurant->image }}"
                                                    alt="" height="80" width="80"
                                                    style="border-radius: 0.275rem;"></td> --}}
                                            
                                            <td style="white-space:normal;">
                                                <div class="orderDatatable-title">{{ $restaurant->name }}
                                                </div>
                                            </td>
                                            
                                            <td>
                                            @if(count($restaurant->users))
                                            @php
                                                $resUsercount = 0;
                                               
                                            @endphp
                                                @foreach($restaurant->users as $restaurantUser)
                                                    @if($restaurantUser->hasRole("Store Owner"))
                                                    @php
                                                        $resUsercount++;
                                                    @endphp
                                                       
                                                        <div>
                                                            <a href="{{ route('admin.impersonate', $restaurantUser->id) }}"
                                                                        class="mr-1" data-popup="tooltip"
                                                            data-placement="left" title="Login as {{ $restaurantUser->name }}" style="border: 1px solid #E0E0E0; border-radius: 0.275rem; padding: 1.5px 4px;"> <i class="fas fa-arrow-alt-circle-right"></i></a>
                                                        <a href="{{ route('admin.get.editUser', $restaurantUser->id) }}">{{ $restaurantUser->name }}</a>
                                                        </div>
                                                      

                                                    @endif
                                                @endforeach
                                                
                                            @if($resUsercount == 0)
                                            <div class="orderDatatable-status d-inline-block">
                                                <span class="order-bg-opacity-success  text-success rounded-pill active">UNASSIGNED</span>
                                            </div>
                                                
                                            @endif
                                            @else
                                                <span class="badge badge-flat border-grey-800 text-default text-capitalize">
                                                    UNASSIGNED
                                                </span>
                                            @endif
                                            </td>
                                            
                                            <td>{{ date('d/m/Y H:i:s', strtotime($restaurant->created_at)) }}</td>
                                            <td class="text-center">
                                                <ul class="orderDatatable_actions mb-0 d-flex flex-wrap float-right">
                                                   
                                                    @if(Request::is('store-owner/stores/deleted'))
                                                    <li>
                                                        <a href="{{ route('admin.restoreStore', $restaurant->id) }}" title="Restaurar" class="edit">
                                                            <span data-feather="rotate-ccw" ></span></a>
                                                    </li>
                                                    @else
                                                    <li>
                                                        <a href="{{ route('admin.getEditStore', $restaurant->id) }}" title="Editar" class="edit">
                                                            <span data-feather="edit"></span></a>
                                                    </li>
                                                    <li>
                                                        <a href="{{ route('admin.deleteStore', $restaurant->id) }}" title="Excluir" onclick="return confirm('Tem certeza de que deseja excluir este item?')" class="remove">
                                                            <span data-feather="trash-2" ></span></a>
                                                    </li>
                                                    @endif
                                                </ul>
                                               
                                                    
                                                   
                                                   
                                                    
                                                
                                                
                                            </td>
                                        </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                {{-- <div class="mt-3">
                                    {{ $items->links() }}
                                </div> --}}
                            </div>
                            <!-- Table Responsive End -->
                        </div>
                        
                        

                    </div>
                    
                     {{-- <div class="mt-4">
                        {{ $coupons->appends($_GET)->links() }}
                    </div>  --}}
                    
                   {{--  <div class="d-flex justify-content-sm-end justify-content-start mt-15 pt-25 border-top">
                        <nav class="atbd-page ">
                            <ul class="atbd-pagination d-flex">
                                <li class="atbd-pagination__item">
                                    <a href="#" class="atbd-pagination__link pagination-control"><span class="la la-angle-left"></span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">1</span></a>
                                    <a href="#" class="atbd-pagination__link active"><span class="page-number">2</span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">3</span></a>
                                    <a href="#" class="atbd-pagination__link pagination-control"><span class="page-number">...</span></a>
                                    <a href="#" class="atbd-pagination__link"><span class="page-number">12</span></a>
                                    <a href="#" class="atbd-pagination__link pagination-control"><span class="la la-angle-right"></span></a>
                                    <a href="#" class="atbd-pagination__option">
                                    </a>
                                </li>
                                <li class="atbd-pagination__item">
                                    <div class="paging-option">
                                        <select name="page-number" class="page-selection">
                                            <option value="20">20/page</option>
                                            <option value="40">40/page</option>
                                            <option value="60">60/page</option>
                                        </select>
                                    </div>
                                </li>
                            </ul>
                        </nav>
                    </div> --}}
                </div><!-- End: .userDatatable -->
            </div><!-- End: .col -->
        </div>
    </div>
</div>












<div id="addNewAddonModal" class="modal fade">
   
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title"><span class="font-weight-bold">Adicionar Loja</span></h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.saveNewRestaurant') }}" method="POST" enctype="multipart/form-data" data-parsley-trigger="keyup" data-parsley-validate>

                    <div class="new-member-modal">
                        <div class="row col-md-12">
                            <div class="col-md-12" style="padding-left: 0px; float: left;"> 
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <i class="" aria-hidden="true"></i> <h5>Dados da Loja</h5>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="card-body pl30 pr30">
                                        <div class="form-group row" style="margin-left: 15px;"> 
                                            <div class="custom-control custom-switch switch-primary switch-md ">
                                                <input type="checkbox" name="is_active" class="custom-control-input" id="is_active" checked>
                                                <label id="produto_ativo" class="custom-control-label" for="is_active" style="color:#0cb946"> Loja Habilitada</label>
                                                <label id="produto_desativado" class="custom-control-label hidden" for="is_active" style="color:#e22f0f"> Loja Desabilitada</label>
                                             </div>
                                            </div>

                                            <div class="form-group mb-20">
                                                <label for="store_name">Nome  da Loja</label>
                                                  <input required type="text"  class="form-control" name="store_name"
                                                  id="store_name" placeholder="">
                                            </div>
                                            <div class="form-group mb-20">
                                                <label for="whatsapp">Whatsapp da Loja</label>
                                                <p><small>*Número que será usado para envio das mensagens. </small></p>
                                          
                                                
                                                  <input required type="text"  class="form-control phone" name="whatsapp"
                                                  id="whatsapp" placeholder=""> 
                                            </div>    
                                            <div class="form-group mb-20">
                                                <label for="email">Email de Acesso</label>
                                                  <input required type="text"  class="form-control" name="email"
                                                  id="email" placeholder="">
                                            </div> 
                                            <div class="form-group mb-20">
                                                <label for="password">Senha</label>
                                                  <input required type="password"  class="form-control" name="password"
                                                  id="password" placeholder="">
                                            </div>  
                                            <div class="form-group mb-20">
                                                <label for="confirm_password">Confirmar Senha</label>
                                                  <input required type="confirm_password"  class="form-control" name="confirm_password"
                                                  id="confirm_password" placeholder="">
                                            </div> 
                                            <div class="form-group mb-20">
                                                <label for="whats_instance">Instância Whatsapp</label>
                                                  <input  type="text"  class="form-control" name="whats_instance"
                                                  id="whats_instance" placeholder="">
                                            </div> 
                                            <div class="form-group mb-20">
                                                <label for="whats_token">Token Whatsapp</label>
                                                  <input  type="text"  class="form-control" name="whats_token"
                                                  id="whats_token" placeholder="">
                                            </div> 
                                            
                          
                                 
                                       
                                        
                                       
                                            {{-- <div class="form-group row">
                                            <label for="name"><span class="text-danger">*</span>Tipo de Desconto</label>
                                            <i class="fas fa-question-circle" 
                                            style="margin-left: 5px"  
                                            tabindex="-1" 
                                            data-trigger="hover"
                                            data-html="true"  
                                            data-toggle="popover" 
                                            title="Tipo de Desconto"  
                                            data-content="Exemplos: <strong>1) Desconto em Reais</strong> (R$ 10,00 de desconto) <strong> 2) Desconto em Porcentagem</strong> (Desconto de 10%)"
                                            ></i>
                                            
                                        <div class="inline-block">
                                            <div class="radio-theme-default custom-radio " style="margin-left:20px" >
                                                <input class="radio type" type="radio" name="discount_type" value="AMOUNT" onchange="valueChanged()" id="radio-un2"  checked>
                                                <label for="radio-un2">
                                                <span class="radio-text">Desconto em Reais (R$)</span>
                                                </label>
                                             </div>
                                             
                                             <div class="radio-theme-default custom-radio" style="margin-left:20px" >
                                                <input class="radio type" type="radio" name="discount_type" value="PERCENTAGE"  onchange="valueChanged()" id="radio-un4"  >
                                                <label for="radio-un4">
                                                <span class="radio-text">Desconto em Porcentagem (%)</span>
                                                </label>
                                             </div>
                                            </div>
                                            </div> 
                                                
                                            
                                            
                                         
                                        
                                           --}}
                                            
                                         

                                    </div>
                                </div>
                            </div> <!-- end col -->

                          {{--   <div class="col-md-6" style="padding-left: 0px; float: left;"> 
                                <div class="card">
                                    <div class="card-header">
                                        <div class="card-title">
                                            <i class="" aria-hidden="true"></i> <h5>Como Funciona o Cupom de Desconto?</h5>
                                        </div>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="card-body pl15 pr15">
                                        
                                        <div class="col-md-12">
                                            <div class='' style="text-align: center;" >
                                                <br>  
                                                <img class="light" style="width: 170px;" src="https://app.comprabakana.com.br/assets/img/cupom.png" alt="">
                                                <br><br>     
                                            </div>
                                        <p><span>Você pode criar Cupons de Descontos com objetivos diferentes  </span></p>
                                    <p><strong>Exemplos:</strong></p>
                                    <p>1) Cupom de R$ 10,00 para compras acima de R$ 50,00;</p>
                                    <p>2) Cupom de R$ 10,00 para compras acima de R$ 50,00 somente para NOVOS CLIENTES (primeira compra);</p>
                                    <p>3) Cupom de 10% de desconto para compras acima de R$ 80,00</p>
                                    <p>4) Cupom de 10% de desconto para compras acima de R$ 80,00 somente para NOVOS CLIENTES (primeira compra);</p>
                                    <p></p>
                                    <p> Você pode ainda limitar a quantidade de cupons disponíveis, e o número de vezes que cada cliente poderá usar o cupom.</p>
                                    </div>
                                        
                                    </div>
                                </div>
                            </div> <!-- end col --> --}}
                        </div>
                    </div>
                    @csrf
                    <br><br>
                    <div class="text-right" style=" display: inline-block; vertical-align: top;">
                        <button type="submit" style=" display: inline-block; vertical-align: top;" class="btn btn-primary">
                            <i class="fas fa-check"></i>
                        Salvar Loja
                        </button>
                        <button  data-dismiss="modal"  style=" marging-left:20px; display: inline-block; vertical-align: top;" class="btn btn-light btn-default btn-squared ">
                            <i class="fas fa-arrow-left"></i>
                        Cancelar
                        </button>
                    </div>

                    


                </form>
            </div>
        </div>
    </div>
</div>




@endsection
@section('scripts')
<script src="{{ URL::asset('assets/libs/multiselect/multiselect.min.js') }}"></script>
<script src="{{ URL::asset('assets/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
<script>
    $("[name='user_type']").change(function() {
        let selectedUserType = $(this).val();
        if (selectedUserType == "CUSTOM") {
             $("[name='max_count_per_user']").attr('required', 'required');
            $('#maxUsePerUser').removeClass('hidden');
        } else {
           $("[name='max_count_per_user']").removeAttr('required')
           $('#maxUsePerUser').addClass('hidden');
        }
    });
</script>

<script>

$('#itemsDataTable').DataTable(
        {
            bLengthChange : true,
            searching: true,
            pageLength : 10,
            bInfo: true,
            lengthMenu: [ 10, 25, 50, 100, 200, 500 ],
            autoWidth: false,
            fixedColumns: { 
                leftColumns: 0,
                rightColumns: 1
            },
            drawCallback: function( settings ) {
                $('select').select2({
                   minimumResultsForSearch: Infinity,
                   width: 'auto'
                });
            },
            
            language: {
                search: '_INPUT_',
                searchPlaceholder: 'Pesquisar...',
                lengthMenu: '_MENU_',
                paginate: { 'first': 'Primeiro', 'last': 'Último', 'next': '&rarr;', 'previous': '&larr;' },
                processing: '<i class="icon-spinner10 spinner position-left mr-1"></i>Buscando Informações no Servidor...',
                info: "Mostrando os registros _START_ a _END_ num total de _TOTAL_",
                emptyTable: "Não foi encontrado nenhum registo",
                loadingRecords: "A carregar...",
                processing: "A processar...",
                
                zeroRecords: "Não foram encontrados resultados",
                infoEmpty: "Mostrando 0 os registros num total de 0",
    infoFiltered: "(filtrado num total de _MAX_ registos)",
    infoThousands: ".",
            },
        }
    );

function valueChanged()
    {
        if($('#radio-un2').is(":checked")) {
            $("#value_amount").show().find("input").prop("required", true);
            $("#value_percentage").hide().find("input").prop("required", false);
        }else{
            $("#value_amount").hide().find("input").prop("required", false);
            $("#value_percentage").show().find("input").prop("required", true);
        }
        if($('#radio-un4').is(":checked")) {
            $("#value_amount").hide().find("input").prop("required", false);
            $("#value_percentage").show().find("input").prop("required", true);
        }  
            
        else{
            $("#value_amount").show().find("input").prop("required", true);
            $("#value_percentage").hide().find("input").prop("required", false);
        }
           

    }


$(function () {
  $('[data-toggle="popover"]').popover()
})


$(document).ready(function() {
		$(".dinheiro").mask('#.##0,00', {
			reverse: true
		}); 
        
    }); 
  

    
    $(document).ready(function() {

        
        $("#is_active").click(function () {
            if ($(this).is(":checked")) {
                $("#produto_ativo").show();
                $("#produto_desativado").hide();
               
            } else {
                $("#produto_ativo").hide();
                $("#produto_desativado").show();
            }
        });
        
    });   

    $(document).ready(function () {
    $('#abrir').click(function () {
        $('#addNewItemModal').modal({
            show: true
        })
    });
    $(document).on('show.bs.modal', '.modal', function (event) {
            var zIndex = 1040 + (10 * $('.modal:visible').length);
            $(this).css('z-index', zIndex);
            setTimeout(function() {
                $('.modal-backdrop').not('.modal-stack').css('z-index', zIndex - 1).addClass('modal-stack');
            }, 0);
    });
});


$('body').tooltip({selector: '[data-popup="tooltip"]'});
    var addonNamePlaceholder = "Nome";
    var addonPricePlaceholder = "Preço";
    var addonRemoveTitle = "Remover";

    function add(data) {
        //$('#addonsLegend').removeClass('hidden');
        var newAddon = document.createElement("div");
        newAddon.innerHTML ="<div class='form-group row'> <div class='col-lg-5'><input type='text' class='form-control  form-control-lg' placeholder='"+addonNamePlaceholder+"' name='addon_names[]' required> </div> <div class='col-lg-5'> <input type='text' class='form-control form-control-lg dinheiro' name='addon_prices[]' placeholder='"+addonPricePlaceholder+"'  required> </div> <div class='col-lg-2'><button class='remove btn btn-danger' data-popup='tooltip' data-placement='right' style='padding:5px' title='"+addonRemoveTitle+"'><i class='la la-trash-alt'></i></button></div></div>";
        document.getElementById('addon').appendChild(newAddon);
        $(".dinheiro").mask('#.##0,00', {
			reverse: true
		});
    }

    $(function() {
        $('.select').select2({
            minimumResultsForSearch: -1,
        });

        $(document).on("click", ".remove", function() {
            $(this).tooltip('hide')
            $(this).parent().parent().remove();
        });
    }); 
 



              


</script>
@endsection


