<!-- Modal -->
<div class="modal fade" id="apbd_pro_modal" data-in-anim="ape-flipInX" data-out-anim="ape-zoomOut" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered animated" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalCenterTitle"><?php $this->_e("Pro Version") ; ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
              <span><?php $this->_e("To unlock these features, you need %s",'<strong>'.$this->__("pro version").'</strong>') ; ?></span> <br/>
                <br/>
                <?php $this->_e("You will get these features in pro version") ; ?>:<br/>
                <i class="fa fa-star"></i> <?php $this->_e("Apply Coupon box can be displayed in mini cart") ; ?><br/>
                <i class="fa fa-star"></i> <?php $this->_e("Applied Coupon box can be displayed in cart") ; ?><br/>
                <i class="fa fa-star"></i> <?php $this->_e("You will get %s Module",'<strong>'.$this->__("Sale Booster").'</strong>') ; ?><br/>
                <i class="fa fa-star"></i> <?php $this->_e("You will get premium support") ; ?>
               
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php $this->_e("Close") ; ?></button>
                <a href="https://appsbd.com/minicartpro?f=freev" target="_blank" class="btn btn-primary"><?php $this->_e("View Details") ; ?></a>
            </div>
        </div>
    </div>
</div>