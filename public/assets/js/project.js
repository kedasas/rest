/**
 * Show / hide loader button
 *
 * @param {object} form - The form object.
 * @param {boolean} show - The triger to enable loader.
 *
 */

function showLoader(form,show) {
    if (show)
    {
        form.find('button span').removeClass('d-none'); //shows loader icon

        form.find('button i').addClass('d-none'); //hides static button icon
    }
    else
    {
        form.find('button span').addClass('d-none'); //hides static button icon
        form.find('button i').removeClass('d-none'); //shows static button
    }
}

/**
 * Submits form using Ajax Poss method and returns html results
 *
 * @param {string} form - The form as html element.
 *
 */

function ajaxFormProc(form){
    var form = $(form);
    var city_alert =  $('#city_alert'); //Alerts jQuery Object

    city_alert.removeClass('alert-danger d-none').addClass('alert d-none').empty(); //clears alerts
    showLoader(form,true);
    $.post( $(this).closest("form").attr('action'), $('#weather_form').serialize(), function( data ) {
        if (data) { //processing results
            if(!!data.warning){
                for (index in data.warning) {
                    city_alert.append(data.warning[index] + '<br />');
                }
                city_alert.removeClass('d-none').addClass('alert-warning');
            }
            else if(!!data.error){
                city_alert.removeClass('d-none').addClass('alert-danger').html(data.error);
            }
            else if(!!data.success){ // adding tabs and tab content
                $('#nav-tab .active').removeClass('active');
                $('#nav-tab').append(data.success.tab_head);
                $('#nav-tabContent .active').removeClass('active show');
                $('#nav-tabContent').append(data.success.tab_cont);
            }
            showLoader(form,false);
        }
    });
}



$(function(){
    /** Form submit event. */
    $( 'form' ).on('submit', function( event ) {
        ajaxFormProc(this);
        event.preventDefault();
    });

});
