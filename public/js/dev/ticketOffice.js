$(document).ready(function () {
    var url = "https://sysprim.com/";

    $('#search').change(function () {
        if ($('#search').val() !== '') {
            var search = $('#search').val();
            $.ajax({
                method: "GET",
                url: url + "/ticket-office/cashier/" + search,
                beforeSend: function () {
                    $("#preloader").fadeIn('fast');
                    $("#preloader-overlay").fadeIn('fast');
                },
                success: function (response) {
                    var taxe = response.taxe[0];
                    var ciu = response.ciu;
                    var company = taxe.companies;

                    $('#fiscal_period').val(taxe.fiscal_period);
                    $('#license').val(company.license);
                    $('#name_company').val(company.name);
                    $('#address').val(company.address);
                    $('#RIF').val(company.RIF);

                    for (var i = 0; i < ciu.length; i++) {

                        var subr = ciu[i].ciu.name.substr(0, 3);


                        var template = `<div>
                                <input type="hidden" name="ciu[]" id="ciu" class="ciu" value="${ciu[i].ciu.id}">
                                <div class="input-field col s12 m5">
                                    <i class="icon-assignment prefix"></i>
                                    <input type="text" name="search-ciu" id="ciu"  disabled value="${ciu[i].ciu.code}">
                                    <label>CIIU</label>
                                </div>
                                <div class="input-field col s10 m6"  >
                                    <i class="icon-text_fields prefix"></i>
                                    <label for="phone">Nombre</label>
                                     <textarea name="${subr}" id="${subr}" cols="30" rows="10" class="materialize-textarea" disabled required>${ciu[i].ciu.name}</textarea>
                                </div>
                                
                               <div class="input-field col s12 m4">
                                    <i class="prefix">
                                        <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                    </i>   
                                    <input type="text" name="base[]" id="base" class="validate money" value="${ciu[i].base}" readonly>
                                    <label for="base">Base Imponible</label>
                                </div>
                                
                                                        
                              <div class="input-field col s12 m4">
                                <i class="prefix">
                                    <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                </i>   
                                <input type="text" name="withholding[]" id="withholdings" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].withholding}" readonly>
                                <label for="withholdings">Retenciones</label>
                              </div>                               
                             
                             
                        
                             <div class="input-field col s12 m4">
                                <i class="prefix">
                                    <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                </i>   
                                <input type="text" name="deductions[]" id="deductions" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].deductions}" readonly>
                                <label for="deductions">Deducciones</label>
                            </div>
                             
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                </i>   
                                <input type="text" name="fiscal_credits[]" id="fiscal_credits" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].fiscal_credits}" readonly>
                                <label for="fiscal_credits">Creditos Fiscales</label>
                            </div>
                           
                           
                            <div class="input-field col s12 m6">
                                <i class="prefix">
                                    <img src="${url}images/isologo-BsS.png" style="width: 2rem" alt="">
                                </i>   
                                <input type="text" name="fiscal_credits[]" id="fiscal_credits" class="validate money" pattern="^[0-9]{0,12}([.][0-9]{2,2})?$" value="${ciu[i].totalCiiu}" readonly>
                                <label for="fiscal_credits">Total CIIU</label>
                            </div> 
                      
                          </div>
                          
                          `;

                        M.textareaAutoResize($('#' + subr));

                        $('#ciu').append(template);

                    }

                    M.updateTextFields();
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');

                },
                error: function (err) {
                    $('#license').val('');
                    $("#preloader").fadeOut('fast');
                    $("#preloader-overlay").fadeOut('fast');
                    swal({
                        title: "¡Oh no!",
                        text: "Ocurrio un error inesperado, refresque la pagina e intentenlo de nuevo.",
                        icon: "error",
                        button: "Ok",
                    });
                }
            });
        }
    });


});