// Change selection list 
$(document).ready(function(){
        var $cat = $('select[name=form]'),
        $items = $('select[name=step]');
        $buttonMenu = $('button[name=changeMenu]');

        $cat.change(function(){
            var $this = $(this).find(':selected'),
            rel = $this.attr('rel'),
            $set = $items.find('option.' + rel);

            if ($set.size() < 0) {
                $items.hide();
                $buttonMenu.hide();
                return;
            }
            $buttonMenu.show();
            $items.show().find('option').hide();

            $set.show().first().prop('selected', true);
        });
    });