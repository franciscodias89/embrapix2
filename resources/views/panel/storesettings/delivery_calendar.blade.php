<div >
  <!-- Edit Profile -->
  <div class="edit-profile edit-social ">
      <div class="card">
          <div class="card-header  px-sm-25 px-3">
              <div class="edit-profile__title">
                  <h6> Horários de Delivery</h6>
                  <span class="fs-13 color-light fw-400">Coloque abaixo todos os horários que seu estabelecimento está disponível para receber pedidos de Delivery.</span>
              </div>
              <div class="button-group d-flex flex-wrap pt-30 mb-15">
                <button type="submit" form="deliverysettigs_form" class="btn btn-primary btn-default btn-squared mr-15 text-capitalize">Salvar
                </button>
             {{--    <button class="btn btn-light btn-default btn-squared fw-400 text-capitalize">cancelar
                </button> --}}
            </div>
          </div>
          <div class="card-body">
            

              <div class="row justify-content-center">
                  <div class="col-lg-9">
                      <div class="edit-profile__body mx-lg-20">

                        <div class="atbd-nav-controller">
                            <div class="btn-group atbd-button-group btn-group-normal nav" role="tablist">
                                
                              @if(($restaurant->delivery_type == 1 )|| ($restaurant->delivery_type == 3))
                               <a href="{{ route('panel.DeliveryCalendar') }}" class="btn btn-sm btn-outline-light nav-link active" id="size-default"  aria-controls="default" aria-selected="true"> Horários de Delivery</a>
                               @endif
                                <a href="{{ route('panel.SelfpickupCalendar') }}" class="btn btn-sm btn-outline-light nav-link" id="size-small"  aria-controls="small" aria-selected="false">Horários para Retirada</a>
                                
                                
                            </div>
                         </div>
                        <form 
                                       action="{{ route('settings.saveDeliveryCalendar') }}" 
                                       method="POST" 
                                       enctype="multipart/form-data" 
                                       data-parsley-trigger="keyup" 
                                       id="deliverysettigs_form"
                                       data-parsley-validate
                                       >
                                       @csrf
                                       <input hidden type="text" value="{{ $restaurant->id }}" class="form-control" name="id">
            
                                       <div class="form-group row mb-0 mt-40">
                                          <div class="col-lg-12">
                                              <h4>Segunda-Feira</h4>
                                          </div>
                                      </div>
                                      <!-- Checks if there is any schedule data -->
                                      @if(!empty($schedule_data->monday) && count($schedule_data->monday) > 0)
                                      <!-- If yes Then Loop Each Data as Time SLots -->
                                      @foreach($schedule_data->monday as $time)
                                      <div class="form-group row">
                                          <div class="col-lg-5">
                                              <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                                              <input type="text"  class="form-control clock" value="{{$time->open}}"
                                                  name="monday[]" required>
                                          </div>
                                          <div class="col-lg-5">
                                              <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                                              <input type="text"  class="form-control clock" value="{{$time->close}}"
                                                  name="monday[]" required>
                                          </div>
                                          <div class="col-lg-2" day="monday">
                                              <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                                              <button class='remove btn btn-danger btn-default btn-squared mr-15' style='padding: 10px;' data-popup='tooltip' data-placement='right' title='Remover Horário'><i class='la la-trash-alt'></i>
                                              </button>
                                          </div>
                                      </div>
                                      @endforeach
                                      @endif
                                      <div id="monday" class="timeSlots">
                                      </div>
                                      <a href="javascript:void(0)" onclick="add(this)" data-day="monday" class="btn btn-primary  mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                                      <hr>
                                      <div class="form-group row mb-0">
                                          <div class="col-lg-12">
                                              <h4>Terça-Feira</h4>
                                          </div>
                                      </div>
                                      <!-- Checks if there is any schedule data -->
                                      @if(!empty($schedule_data->tuesday) && count($schedule_data->tuesday) > 0)
                                      <!-- If yes Then Loop Each Data as Time SLots -->
                                      @foreach($schedule_data->tuesday as $time)
                                      <div class="form-group row">
                                          <div class="col-lg-5">
                                              <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                                              <input type="text" class="form-control clock " value="{{$time->open}}"
                                                  name="tuesday[]" required>
                                          </div>
                                          <div class="col-lg-5">
                                              <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                                              <input type="text" class="form-control clock " value="{{$time->close}}"
                                                  name="tuesday[]" required>
                                          </div>
                                          <div class="col-lg-2" day="tuesday">
                                              <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                                              <button class='remove btn btn-danger btn-default btn-squared mr-15' style='padding: 10px;' data-popup='tooltip' data-placement='right' title='Remover Horário'><i class='la la-trash-alt'></i>
                                              </button>
                                          </div>
                                      </div>
                                      @endforeach
                                      @endif
                                      <div id="tuesday" class="timeSlots">
                                      </div>
                                      <a href="javascript:void(0)" onclick="add(this)" data-day="tuesday" class="btn btn-primary mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                                      <hr>
                                      <div class="form-group row mb-0">
                                          <div class="col-lg-12">
                                              <h4>Quarta-Feira</h4>
                                          </div>
                                      </div>
                                      <!-- Checks if there is any schedule data -->
                                      @if(!empty($schedule_data->wednesday) && count($schedule_data->wednesday) > 0)
                                      <!-- If yes Then Loop Each Data as Time SLots -->
                                      @foreach($schedule_data->wednesday as $time)
                                      <div class="form-group row">
                                          <div class="col-lg-5">
                                              <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                                              <input type="text" class="form-control clock" value="{{$time->open}}"
                                                  name="wednesday[]" required>
                                          </div>
                                          <div class="col-lg-5">
                                              <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                                              <input type="text" class="form-control clock" value="{{$time->close}}"
                                                  name="wednesday[]" required>
                                          </div>
                                          <div class="col-lg-2" day="wednesday">
                                              <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                                              <button class='remove btn btn-danger btn-default btn-squared mr-15' style='padding: 10px;' data-popup='tooltip' data-placement='right' title='Remover Horário'><i class='la la-trash-alt'></i>
                                              </button>
                                          </div>
                                      </div>
                                      @endforeach
                                      @endif
                                      <div id="wednesday" class="timeSlots">
                                      </div>
                                      <a href="javascript:void(0)" onclick="add(this)" data-day="wednesday" class="btn btn-primary  mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                                      <hr>
                                      <div class="form-group row mb-0">
                                          <div class="col-lg-12">
                                              <h4>Quinta-Feira</h4>
                                          </div>
                                      </div>
                                      <!-- Checks if there is any schedule data -->
                                      @if(!empty($schedule_data->thursday) && count($schedule_data->thursday) > 0)
                                      <!-- If yes Then Loop Each Data as Time SLots -->
                                      @foreach($schedule_data->thursday as $time)
                                      <div class="form-group row">
                                          <div class="col-lg-5">
                                              <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                                              <input type="text" class="form-control clock" value="{{$time->open}}"
                                                  name="thursday[]" required>
                                          </div>
                                          <div class="col-lg-5">
                                              <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                                              <input type="text" class="form-control clock" value="{{$time->close}}"
                                                  name="thursday[]" required>
                                          </div>
                                          <div class="col-lg-2" day="thursday">
                                              <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                                              <button class='remove btn btn-danger btn-default btn-squared mr-15' style='padding: 10px;' data-popup='tooltip' data-placement='right' title='Remover Horário'><i class='la la-trash-alt'></i>
                                              </button>
                                          </div>
                                      </div>
                                      @endforeach
                                      @endif
                                      <div id="thursday" class="timeSlots">
                                      </div>
                                      <a href="javascript:void(0)" onclick="add(this)" data-day="thursday" class="btn btn-primary  mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                                      <hr>
                                      <div class="form-group row mb-0">
                                          <div class="col-lg-12">
                                              <h4>Sexta-Feira</h4>
                                          </div>
                                      </div>
                                      <!-- Checks if there is any schedule data -->
                                      @if(!empty($schedule_data->friday) && count($schedule_data->friday) > 0)
                                      <!-- If yes Then Loop Each Data as Time SLots -->
                                      @foreach($schedule_data->friday as $time)
                                      <div class="form-group row">
                                          <div class="col-lg-5">
                                              <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                                              <input type="text" class="form-control clock" value="{{$time->open}}"
                                                  name="friday[]" required>
                                          </div>
                                          <div class="col-lg-5">
                                              <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                                              <input type="text" class="form-control clock" value="{{$time->close}}"
                                                  name="friday[]" required>
                                          </div>
                                          <div class="col-lg-2" day="friday">
                                              <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                                              <button class='remove btn btn-danger btn-default btn-squared mr-15' style='padding: 10px;' data-popup='tooltip' data-placement='right' title='Remover Horário'><i class='la la-trash-alt'></i>
                                              </button>
                                          </div>
                                      </div>
                                      @endforeach
                                      @endif 
                                      <div id="friday" class="timeSlots">
                                      </div>
                                      <a href="javascript:void(0)" onclick="add(this)" data-day="friday" class="btn btn-primary mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                                      <hr>
                                      <div class="form-group row mb-0">
                                          <div class="col-lg-12">
                                              <h4>Sábado</h4>
                                          </div>
                                      </div>
                                      <!-- Checks if there is any schedule data -->
                                      @if(!empty($schedule_data->saturday) && count($schedule_data->saturday) > 0)
                                      <!-- If yes Then Loop Each Data as Time SLots -->
                                      @foreach($schedule_data->saturday as $time)
                                      <div class="form-group row">
                                          <div class="col-lg-5">
                                              <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                                              <input type="text" class="form-control clock" value="{{$time->open}}"
                                                  name="saturday[]" required>
                                          </div>
                                          <div class="col-lg-5">
                                              <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                                              <input type="text" class="form-control clock" value="{{$time->close}}"
                                                  name="saturday[]" required>
                                          </div>
                                          <div class="col-lg-2" day="saturday">
                                              <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                                              <button class='remove btn btn-danger btn-default btn-squared mr-15' style='padding: 10px;' data-popup='tooltip' data-placement='right' title='Remover Horário'><i class='la la-trash-alt'></i>
                                              </button>
                                          </div>
                                      </div>
                                      @endforeach
                                      @endif
                                      <div id="saturday" class="timeSlots">
                                      </div>
                                      <a href="javascript:void(0)" onclick="add(this)" data-day="saturday" class="btn btn-primary  mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                                      <hr>
                                      <div class="form-group row mb-0">
                                          <div class="col-lg-12">
                                              <h4>Domingo</h4>
                                          </div>
                                      </div>
                                      <!-- Checks if there is any schedule data -->
                                      @if(!empty($schedule_data->sunday) && count($schedule_data->sunday) > 0)
                                      <!-- If yes Then Loop Each Data as Time SLots -->
                                      @foreach($schedule_data->sunday as $time)
                                      <div class="form-group row">
                                          <div class="col-lg-5">
                                              <label class="col-form-label">{{ __('storeDashboard.seOpeningTime') }}</label>
                                              <input type="text" class="form-control clock" value="{{$time->open}}"
                                                  name="sunday[]" required>
                                          </div>
                                          <div class="col-lg-5">
                                              <label class="col-form-label"></span>{{ __('storeDashboard.seClosingTime') }}</label>
                                              <input type="text" class="form-control clock" value="{{$time->close}}"
                                                  name="sunday[]" required>
                                          </div>
                                          <div class="col-lg-2" day="sunday">
                                              <label class="col-form-label text-center" style="width: 70px;"></span>Remover</label><br>
                                             
                                              <button class='remove btn btn-danger btn-default btn-squared mr-15' style='padding: 10px;' data-popup='tooltip' data-placement='right' title='Remover Horário'><i class='la la-trash-alt'></i>
                                             </button>
                                          </div>
                                      </div>
                                      @endforeach
                                      @endif
                                      <div id="sunday" class="timeSlots">
                                      </div>
                                      <a href="javascript:void(0)" onclick="add(this)" data-day="sunday" class="btn btn-primary  mr-2"> <b><i class="icon-plus22"></i></b>Adicionar Horário</a>
                                      <hr>
                                    
                                      <div class="form-group mb-20">
                                           
                                     </div>
                                       
                                      


                                   
            
                                       
            
                                             
                                             <div class="d-flex pt-15 justify-content-md-end justify-content-center">
                                                <button type="submit" class="btn btn-danger btn-default btn-squared mr-15">Salvar e Continuar<i class="ml-10 mr-0 las la-arrow-right"></i>
                                                </button>
                                                
                                          </div>
                                          
                                             
                                          </form>
                     
                      </div>
                  </div>
              </div>
          </div>
      </div>
  </div>
  <!-- Edit Profile End -->
</div>


@section('scripts')






<script>
    
    $(document).ready(function() {
                var status= "<?php  echo $restaurant->status; ?>";  
                
                /* if (status<=7) {
                    $('.sidebar').addClass('hiddeen');
                    $('.contents').addClass('contents2');
                } */
                if (status<=20) {
                    $('.sidebar').addClass('collapsed');
                    $('.contents').addClass('expanded');
                }
                });



                


$(document).ready(function() {
    $(".dinheiro").mask('#.##0,00', {
        reverse: true
    });
    $(".agencia").mask('000.000.000-00', {
        reverse: true
    });
    $('.cpf').mask('000.000.000-00', {reverse: true});
    $('.cnpj').mask('00.000.000/0000-00', {reverse: true});
//
//MASCARA DE TELEFONE
    var behavior = function (val) {
    return val.replace(/\D/g, '').length === 11 ? '(00) 00000-0000' : '(00) 0000-00009';
},
options = {
    onKeyPress: function (val, e, field, options) {
        field.mask(behavior.apply({}, arguments), options);
    }
};

$('.phone').mask(behavior, options);
//MASCARA DE TELEFONE - FIM



});

function readURL(input) {
    
    if (input.files && input.files[0]) {
        let reader = new FileReader();
        reader.onload = function (e) {
            $('.slider-preview-image')
                .removeClass('hidden')
                .attr('src', e.target.result);



        };

        //ocument.getElementsByClassName(".slider-preview-image").style.objectFit = "cover";
        reader.readAsDataURL(input.files[0]);
    }
}
 function add(data) {
    var para = document.createElement("div");
    let day = data.getAttribute("data-day");
    let randomNum = 'clock'+Math.random(); 
    para.innerHTML ="<div class='form-group row'> <div class='col-lg-5'><label class='col-form-label'>Abre às:</label><input type='text' class='form-control clock' name='"+day+"[]' required> </div> <div class='col-lg-5'> <label class='col-form-label'>Fecha às:</label><input type='text' class='form-control clock' name='"+day+"[]'  required> </div> <div class='col-lg-2'> <label class='col-form-label text-center' style='width: 70px'></span>Remover</label><br><button class='remove btn btn-danger btn-default btn-squared mr-15' style='padding: 10px;' data-popup='tooltip' data-placement='right' title='Remover Horário'><i class='la la-trash-alt'></i></button></div></div>";
    document.getElementById(day).appendChild(para);
    var parent = document.getElementById('id');
    initializeFlatPicker(para);
  

}

function initializeFlatPicker (context) {
$(".clock", context || document).flatpickr({
enableTime: true,
noCalendar: true,
time_24hr: true,
dateFormat: "H:i",
});
}



$(function () {

    /* $('body').tooltip({
        selector: 'button'
    }); */
    
    $('.clock').flatpickr({
        enableTime: true,
noCalendar: true,
time_24hr: true,
dateFormat: "H:i",
    });
    $(document).on("click", ".remove", function() {
        //$(this).tooltip('hide')
        $(this).parent().parent().remove();
    });
    
    $('.select').select2({
        minimumResultsForSearch: Infinity,
    });

     if (Array.prototype.forEach) {
           var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery-primary'));
           elems.forEach(function(html) {
               var switchery = new Switchery(html, { color: '#2196F3' });
           });
       }
       else {
           var elems = document.querySelectorAll('.switchery-primary');
           for (var i = 0; i < elems.length; i++) {
               var switchery = new Switchery(elems[i], { color: '#2196F3' });
           }
       }

//    $('.form-control-uniform').uniform();

   
});

$("#select2").change(function() {
$("#select2").trigger('input')
})

$("#select-categories").select2({
        placeholder: "Selecione uma Categoria",
        dropdownCssClass: "tag",
        
        allowClear: true,
    });

$(".person_type").on('change', function () {
        if ($(this).val() == "Pessoa Jurídica") {
            $('#pessoafisicaDIV').addClass('hidden').find("input").prop("required", false);
     
            $('#pessoajuridicaDIV').removeClass('hidden').find("input").prop("required", true);
        }
        if ($(this).val()  == "Pessoa Física") {
            $('#pessoajuridicaDIV').addClass('hidden').find("input").prop("required", false);
          
            $('#pessoafisicaDIV').removeClass('hidden').find("input").prop("required", true);
        }
});

$("#bank").select2({
        placeholder: "Selecione uma Opção...",
        dropdownCssClass: "option2",
        
        allowClear: true,
    });



var person_type= "<?php  echo $subaccount->person_type; ?>";  
if (person_type==='Pessoa Jurídica') {
    $('#pessoafisicaDIV').addClass('hidden').find("input").prop("required", false);
   
    $('#pessoajuridicaDIV').removeClass('hidden').find("input").prop("required", true);
}
if (person_type=== "Pessoa Física") {
    $('#pessoajuridicaDIV').addClass('hidden').find("input").prop("required", false);
    
    $('#pessoafisicaDIV').removeClass('hidden').find("input").prop("required", true);
}




function bindDataToForm(address, lat, lng) {
    document.getElementById('location').value = address;
    document.getElementById('lat').value = lat;
    document.getElementById('lng').value = lng;
}


$(document).ready(function () {



if (Array.prototype.forEach) {
var elems = Array.prototype.slice.call(document.querySelectorAll('.switchery-primary'));
elems.forEach(function (html) {
    var switchery = new Switchery(html, {
        color: '#2196F3'
    });
});
} else {
var elems = document.querySelectorAll('.switchery-primary');
for (var i = 0; i < elems.length; i++) {
    var switchery = new Switchery(elems[i], {
        color: '#2196F3'
    });
}
}

var delivery_charge_type= "<?php  echo $restaurant->delivery_charge_type; ?>";  

if (delivery_charge_type==='DYNAMIC') {
  
$('#deliveryCharge').addClass('hidden');
$('#dynamicChargeDiv').removeClass('hidden')
}
if (delivery_charge_type=== "FIXED") {
    
    $('#dynamicChargeDiv').addClass('hidden');
    $('#deliveryCharge').removeClass('hidden')
}
if (delivery_charge_type=== "FREE") {

$('#dynamicChargeDiv').addClass('hidden');
$('#deliveryCharge').addClass('hidden')
}  


$("[name='delivery_charge_type']").on("change", function () {
if ($(this).val() == "FIXED") {
    
    $('#dynamicChargeDiv').addClass('hidden');
    $('#deliveryCharge').removeClass('hidden')
}
if ($(this).val() == "DYNAMIC") {

   
    $('#deliveryCharge').addClass('hidden');
    $('#dynamicChargeDiv').removeClass('hidden')
}
if ($(this).val() == "FREE") {

    $('#dynamicChargeDiv').addClass('hidden');
    $('#deliveryCharge').addClass('hidden')
}


});







// $('.form-control-uniform').uniform();

$('#downloadSampleRestaurantCsv').click(function (event) {
event.preventDefault();
window.location.href = "{{substr(url(" / "), 0, strrpos(url(" / "), '/'))}}/assets/docs/restaurants-sample-csv.csv";
});

/* $('.rating').numeric({
allowThouSep: false,
min: 1,
max: 5,
maxDecimalPlaces: 1
});
$('.delivery_time').numeric({
allowThouSep: false
});
$('.price_range').numeric({
allowThouSep: false
});
$('.latitude').numeric({
allowThouSep: false
});
$('.longitude').numeric({
allowThouSep: false
});
$('.restaurant_charges').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
allowMinus: false
});
$('.delivery_charges').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
allowMinus: false
});
$('.commission_rate').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
max: 100,
allowMinus: false
});

$('.delivery_radius').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
allowMinus: false
});

$('.base_delivery_charge').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
allowMinus: false
});
$('.base_delivery_distance').numeric({
allowThouSep: false,
maxDecimalPlaces: 0,
allowMinus: false
});
$('.extra_delivery_charge').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
allowMinus: false
});
$('.extra_delivery_distance').numeric({
allowThouSep: false,
maxDecimalPlaces: 0,
allowMinus: false
});

$('.min_order_price').numeric({
allowThouSep: false,
maxDecimalPlaces: 2,
allowMinus: false
});
 */






});


$(document).ready(function() {
   
   
   // enable fileupload plugin
   $('input[name="files"]').fileuploader({
      limit: 2,
        extensions: ['jpg','jpeg','png','bpm',''],
      fileMaxSize: 10,
      changeInput: ' ',
      theme: 'avatar',
      addMore: true,
        enableApi: true,
      thumbnails: {
         box: '<div class="fileuploader-wrapper">' +
               '<div class="fileuploader-items"></div>' +
               '<div class="fileuploader-droparea" data-action="fileuploader-input"><i class="fileuploader-icon-main"></i></div>' +
               '</div>' +
               '<div class="fileuploader-menu">' +
                  '<button type="button" class="fileuploader-menu-open"><i class="fileuploader-icon-menu"></i></button>' +
                  '<ul>' +
                     '<li><a data-action="fileuploader-input"><i class="fileuploader-icon-upload"></i> ${captions.upload}</a></li>' +
                     '<li><a data-action="fileuploader-edit"><i class="fileuploader-icon-edit"></i> ${captions.edit}</a></li>' +
                     '<li><a data-action="fileuploader-remove"><i class="fileuploader-icon-trash"></i> ${captions.remove}</a></li>' +
                  '</ul>' +
               '</div>',
         item: '<div class="fileuploader-item">' +
                  '${image}' +
                 '<span class="fileuploader-action-popup" data-action="fileuploader-edit"></span>' +
                 '<div class="progressbar3" style="display: none"></div>' +
               '</div>',
         item2: null,
         itemPrepend: true,
         startImageRenderer: true,
            canvasImage: false,
         _selectors: {
            list: '.fileuploader-items'
         },
         popup: {
            arrows: false,
            onShow: function(item) {
               item.popup.html.addClass('is-for-avatar');
                    item.popup.html.on('click', '[data-action="remove"]', function(e) {
                        item.popup.close();
                        item.remove();
                    }).on('click', '[data-action="cancel"]', function(e) {
                        item.popup.close();
                    }).on('click', '[data-action="save"]', function(e) {
                  if (item.editor && !item.isSaving) {
                     item.isSaving = true;
                           item.editor.save();
                  }
                  if (item.popup.close)
                     item.popup.close();
                    });
                },
            onHide: function(item) {
               if (!item.isSaving && !item.uploaded && !item.appended) {
                  item.popup.close = null;
                  item.remove();
               }
            } 	
         },
         onItemShow: function(item) {
            if (item.choosed)
               item.html.addClass('is-image-waiting');
         },
         onImageLoaded: function(item, listEl, parentEl, newInputEl, inputEl) {
                if (item.choosed && !item.isSaving) {
               if (item.reader.node && item.reader.width >= 256 && item.reader.height >= 256) {
                  item.image.hide();
                  item.popup.open();
                  item.editor.cropper();
               } else {
                  item.remove();
                  alert('A imagem é muito pequena. Tente enviar uma outra imagem maior!');
               }
            } else if (item.data.isDefault)
               item.html.addClass('is-default');
            else if (item.image.hasClass('fileuploader-no-thumbnail'))
               item.html.hide();
            },
         onItemRemove: function(html) {
            html.fadeOut(250, function() {
               html.remove();
            });
         }
      },
      dragDrop: {
         container: '.fileuploader-wrapper'
      },
      editor: {
         maxWidth: 300,
         maxHeight: 300,
         quality: 65,
            cropper: {
            showGrid: false,
            ratio: '1:1',
            minWidth: 150,
            minHeight: 150,
         },
         onSave: function(base64, item, listEl, parentEl, newInputEl, inputEl) {
            var api = $.fileuploader.getInstance(inputEl);
                
                if (!base64)
                    return;
            
            // blob
            item.editor._blob = api.assets.dataURItoBlob(base64, item.type);
            
            if (item.upload) {
               if (api.getFiles().length == 2 && (api.getFiles()[0].data.isDefault || api.getFiles()[0].upload))
                  api.getFiles()[0].remove();
               parentEl.find('.fileuploader-menu ul a').show();
               
               if (item.upload.send)
                  return item.upload.send();
               if (item.upload.resend)
                  return item.upload.resend();
            } else if (item.appended) {
               var form = new FormData();
               
               // hide current thumbnail (this is only animation)
               item.image.addClass('fileuploader-loading').html('');
               item.html.find('.fileuploader-action-popup').hide();
               parentEl.find('[data-action="fileuploader-edit"]').hide();
               
               // send ajax
               form.append(inputEl.attr('name'), item.editor._blob);
               form.append('fileuploader', true);
               form.append('name', item.name);
               form.append('editing', true);
               form.append('restaurant_id','{{ $restaurant->id }}');
                    form.append('_token','{{ csrf_token() }}');
                    
               $.ajax({
                  url: api.getOptions().upload.url,
                  data: form,
                  type: 'POST',
                  processData: false,
                  contentType: false
               }).always(function() {
                  delete item.isSaving;
                  item.reader.read(function() {
                     item.html.find('.fileuploader-action-popup').show();
                     parentEl.find('[data-action="fileuploader-edit"]').show();
                     item.popup.html = item.popup.node = item.popup.editor = item.editor.crop = item.editor.rotation = item.popup.zoomer = null;
                     item.renderThumbnail();
                  }, null, true);
               });
            }
         }
        },
      upload: {
            url:  '{{ route('restaurant.uploadLogoRestaurant') }}',
            data: null, // should be null
            type: 'POST',
            enctype: 'multipart/form-data',
            start: false,
            beforeSend: function(item, listEl, parentEl, newInputEl, inputEl) {
                item.upload.formData = new FormData();

                if (item.editor && item.editor._blob) {
                    item.upload.data.fileuploader = 1;
                    item.upload.data.name = item.name;
                    item.upload.data.editing = item.uploaded;
                    item.upload.data.restaurant_id = '{{ $restaurant->id }}';
                    item.upload.data._token = '{{ csrf_token() }}';

                    item.upload.formData.append(inputEl.attr('name'), item.editor._blob, item.name);
                }

                item.image.hide();
                item.html.removeClass('upload-complete');
                parentEl.find('[data-action="fileuploader-edit"]').hide();
                this.onProgress({percentage: 0}, item);
            },
            onSuccess: function(result, item, listEl, parentEl, newInputEl, inputEl) {
                var api = $.fileuploader.getInstance(inputEl),
               $progressBar = item.html.find('.progressbar3'),
               data = {};
            
            if (result && result.files)
                    data = result;
                else
               data.hasWarnings = true;
            
            if (api.getFiles().length > 1)
               api.getFiles()[0].remove();
                
            // if success
                if (data.isSuccess && data.files[0]) {
                    item.name = data.files[0].name;
            }
            
            // if warnings
            if (data.hasWarnings) {
               for (var warning in data.warnings) {
                  alert(data.warnings[warning]);
               }
               
               item.html.removeClass('upload-successful').addClass('upload-failed');
               return this.onError ? this.onError(item) : null;
            }
            
            delete item.isSaving;
            item.html.addClass('upload-complete').removeClass('is-image-waiting');
            $progressBar.find('span').html('<i class="fileuploader-icon-success"></i>');
            parentEl.find('[data-action="fileuploader-edit"]').show();
            setTimeout(function() {
               $progressBar.fadeOut(450);
            }, 1250);
            item.image.fadeIn(250);
            },
            onError: function(item, listEl, parentEl, newInputEl, inputEl) {
            var $progressBar = item.html.find('.progressbar3');
            
            item.html.addClass('upload-complete');
            if (item.upload.status != 'cancelled')
               $progressBar.find('span').attr('data-action', 'fileuploader-retry').html('<i class="fileuploader-icon-retry"></i>');
            },
            onProgress: function(data, item) {
                var $progressBar = item.html.find('.progressbar3');
            
            if (data.percentage == 0)
               $progressBar.addClass('is-reset').fadeIn(250).html('');
            else if (data.percentage >= 99)
               data.percentage = 100;
            else
               $progressBar.removeClass('is-reset');
            if (!$progressBar.children().length)
               $progressBar.html('<span></span><svg><circle class="progress-dash"></circle><circle class="progress-circle"></circle></svg>');
            
            var $span = $progressBar.find('span'),
               $svg = $progressBar.find('svg'),
               $bar = $svg.find('.progress-circle'),
               hh = Math.max(60, item.html.height() / 2),
               radius = Math.round(hh / 2.28),
               circumference = radius * 2 * Math.PI,
               offset = circumference - data.percentage / 100 * circumference;
            
            $svg.find('circle').attr({
               r: radius,
               cx: hh,
               cy: hh
            });
            $bar.css({
               strokeDasharray: circumference + ' ' + circumference,
               strokeDashoffset: offset
            });
            
            $span.html(data.percentage + '%');
            },
            onComplete: null,
        },
      afterRender: function(listEl, parentEl, newInputEl, inputEl) {
         var api = $.fileuploader.getInstance(inputEl);
         
         // remove multiple attribute
         inputEl.removeAttr('multiple');
            
            // set drop container
            api.getOptions().dragDrop.container = parentEl.find('.fileuploader-wrapper');
         
         // disabled input
         if (api.isDisabled()) {
            parentEl.find('.fileuploader-menu').remove();
         }
         
         // [data-action]
         parentEl.on('click', '[data-action]', function() {
            var $this = $(this),
               action = $this.attr('data-action'),
               item = api.getFiles().length ? api.getFiles()[api.getFiles().length-1] : null;
            
            switch (action) {
               case 'fileuploader-input':
                  api.open();
                  break;
               case 'fileuploader-edit':
                  if (item && item.popup) {
                     if (!$this.is('.fileuploader-action-popup'))
                        item.popup.open();
                     item.editor.cropper();
                  }
                  break;
               case 'fileuploader-retry':
                  if (item && item.upload.retry)
                     item.upload.retry();
                  break;
               case 'fileuploader-remove':
                  if (item)
                     item.remove();
                  break;
            }
         });
         
         // menu
         $('body').on('click', function(e) {
            var $target = $(e.target),
               $parent = $target.closest('.fileuploader');
            
            $('.fileuploader-menu').removeClass('is-shown');
            if ($target.is('.fileuploader-menu-open') || $target.closest('.fileuploader-menu-open').length)
               $parent.find('.fileuploader-menu').addClass('is-shown');
         });
      },
      onEmpty: function(listEl, parentEl, newInputEl, inputEl) {
         var api = $.fileuploader.getInstance(inputEl),
            defaultAvatar = inputEl.attr('data-fileuploader-default');
         
         if (defaultAvatar && !listEl.find('> .is-default').length)
            api.append({name: '', type: 'image/png', size: 0, file: defaultAvatar, data: {isDefault: true, popup: false, listProps: {is_default: true}}});
         
         parentEl.find('.fileuploader-menu ul a').hide().filter('[data-action="fileuploader-input"]').show();
      },
      onRemove: function(item) {
         if (item.name && (item.appended || item.uploaded))
            $.post('php/ajax_remove_file.php', {
               file: item.name
            });
      },
      captions: $.extend(true, {}, $.fn.fileuploader.languages['en'], {
         edit: 'Edit',
         upload: 'Upload',
         remove: 'Remove',
         errors: {
              filesLimit: 'Only 1 file is allowed to be uploaded.',
         }
      })
    });
});





</script>
@endsection