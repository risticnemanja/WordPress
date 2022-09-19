(function ($) {

    $(document).ready(function () {
        jQuery('.wpcf7-form').each(function(){
                var form_id = $(this).find("input[name=_wpcf7]").val(),
                navListItems  = $(this).find('.uacf7-steps div.setup-panel div a[data-form-id="' + form_id + '"]'),
                allWells      = $(this).find('.uacf7-step'),
                allNextBtn    = $(this).find('.uacf7-next[data-form-id="' + form_id + '"]'),
                allPrevBtn    = $(this).find('.uacf7-prev[data-form-id="' + form_id + '"]'),
                allStepTitle  =  $(this).find('.step-title[data-form-id="' + form_id + '"]');  
                
                allWells.hide();

                navListItems.click(function (e) {
                    e.preventDefault();
                    var $target = $($(this).attr('href')),
                        title   = $($(this).attr('title-id')),
                        $item   = $(this);

                    if (!$item.hasClass('disabled')) {
                        navListItems.removeClass('uacf7-btn-active').addClass('uacf7-btn-default');
                        $item.addClass('uacf7-btn-active');
                        allWells.hide();
                        $target.show();
                        allStepTitle.hide();
                        title.show();
                        $target.find('input:eq(0)').focus();
                    }
                });

                allPrevBtn.click(function () {
                    var curStep = $(this).closest(".uacf7-step"),
                        curStepBtn = curStep.attr("id"),
                        prevStepSteps = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().prev().children("a");

                    prevStepSteps.removeAttr('disabled').trigger('click');
                });

                allNextBtn.click(function () {
                    var curStep = $(this).closest(".uacf7-step"),
                        curStepBtn = curStep.attr("id"),
                        nextStepWizard = $('div.setup-panel div a[href="#' + curStepBtn + '"]').parent().next().children("a"),
                        curInputs = curStep.find("input[type='text'],input[type='url']"),
                        isValid = true;

                    $(".form-group").removeClass("has-error");
                    for (var i = 0; i < curInputs.length; i++) {
                        if (!curInputs[i].validity.valid) {
                            isValid = false;
                            $(curInputs[i]).closest(".form-group").addClass("has-error");
                        }
                    }

                    //if (isValid)
                        //nextStepWizard.removeAttr('disabled').trigger('click');
                });

                //$('div.setup-panel div a.uacf7-btn-active').trigger('click');
                $('#'+form_id+'step-1.uacf7-step.step-content.step-start').show();
        });
        
    });
})(jQuery);
