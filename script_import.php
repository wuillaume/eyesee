
<script>
// ABLE TO EDIT a normal text field
$(document.documentElement)
    .on("click", "span.item-display", function(event) {
        $(event.currentTarget)
            .hide()
            .next("span.item-field")
            .show()
            .find(":input:first")
            .focus()
            .select();
    })
    .on("keypress", "span.item-field", function(event) {
        if (event.keyCode != 13)
            return;
        
        event.preventDefault();
        
        var $field = $(event.currentTarget),
            $display = $field.prev("span.item-display");
        
        $display.html($field.find(":input:first").val());
        $display.show();
        $field.hide();
    });
</script>
<style>
.item-display {
    cursor: pointer;
}
.item-field {
    display: none;
}
</style>