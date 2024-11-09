var image_dimensions = [];
const callImageDimensionsApi = () => {
    fetch('/api/image_dimensions')
        .then(response => response.json())
        .then(data => {
            image_dimensions = data.response;
            let body = $('body');
            body.css('opacity', '1');
            body.css('pointer-events', 'auto');
        })
        .catch(error => {
            console.error('There was an error!', error);
        });
}

{
    let body = $('body');
    body.css('opacity', '0.6');
    body.css('pointer-events', 'none');
    callImageDimensionsApi();
}

const checkImageDimensions = (_this) => {
    let type = $(_this).data('type');
    let dimensions = image_dimensions[type];
    console.log(dimensions);
    const file = _this.files[0];
    if (file) {
        const img = new Image();
        img.src = URL.createObjectURL(file);
        img.onload = function() {
            const width = img.width;
            const height = img.height;
            URL.revokeObjectURL(img.src); // Free up memory

            if (width > dimensions.width || height > dimensions.height) {
                alert(`The image dimensions should be ${dimensions.width}x${dimensions.height} pixels or smaller.`);
                _this.value = ""; // Clear the input
                // remove from text field if exists
                let field = $('#'+type+'_text_field');
                if(field.length){
                    field.val('');
                }
            }
        };
    }
}