
jQuery(document).ready(function(){

    jQuery('.btn_md5').on('click', function () {

        jQuery('#results').html("")
        var data_for_ajax = new Array()
        var content = jQuery('#wt_textarea').val()
        if(!content.length) {
            alert('You must write something in the textarea')
            return false
        }
        content = content.replace(/ +(?= )/g, '');
        content = content.replace(/(?:\r\n|\r|\n)/g, 'line_break')
        content = content.split('line_break')

        for (let index = 0; index < content.length; index++) {
            const element = content[index];
            
            if (element.length < 5) continue

            var new_line = element.split(" ")

            if (new_line.length != 3){
                jQuery('#results').append("<p style='color:red'>Line <strong>"+element+"</strong> does not have the right format</p>")
                continue
            }else{
                jQuery('#results').append("<p style='color:green'>Line <strong>"+element+"</strong> has the right format</p>")
            }
            
            var new_element = {}

            new_element.id = new_line[0]
            new_element.name = new_line[1]
            new_element.md5 = new_line[2].toUpperCase()

            data_for_ajax.push(new_element)

        }
        
        if(!data_for_ajax.length){
            alert('There is not a valid element in textarea')
            return false
        }

        jQuery.ajax({
            type: 'POST',
            url: ajax_object.ajax_url,
            dataType: 'json',
            data: {
                action:'manage_data',
                data: data_for_ajax
            },
            beforeSend: function () {
                jQuery('#results').append("<p class='loading'>Loading...</p>")
            },
            error: function (qXHR, textStatus, errorThrow) {
                jQuery('#results').append("</br>qXHR: "+qXHR)
                jQuery('#results').append("</br>textStatus: " + textStatus)
                jQuery('#results').append("</br>errorThrow: " + errorThrow)
            },
            complete: function () {},
            success: function (html) {
                jQuery('.loading').hide()
                jQuery('#results').append("Resultados: <br>")
                html.forEach(element => {          
                    jQuery('#results').append(element)
                });
            }
        });

    });

})

function getHomeUrl() {
    var href = window.location.href;
    var index = href.indexOf('/wp-admin');
    var homeUrl = href.substring(0, index);
    return homeUrl;
}
