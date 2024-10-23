
const viewMoreProducts = (cat_id, pid, offset) => {
    let div = $('#viewMore');
    let button = div.find('.viewMoreBtn');
    let data = {
        cat_id: cat_id,
        pid: pid,
        offset: offset,
    }
    $.ajax({
        url: baseUrl+"/products/load/more",
        type: "GET",
        data,
        beforeSend: function() {
            button.text('Loading...');
            button.attr('disabled', true);
        },
        success: function (response) {
            div.remove();
            $('#viewMoreDiv').append(response);
        }
    });
}