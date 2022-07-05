<section class="container content-section">
    <div class="shop-items">
        <?php
        foreach ($itemsbyid->result() as $row)
            {  		
        ?> 
                <div class="shop-item">
                    <input type="hidden" name="user_id" value="<?php echo $this->session->userdata('id'); ?>">
                    <input type="hidden" name="item_id" value="<?php echo $row->id; ?>">
                    <div class="shop-item-title">
                        <?php echo $row->title; ?>
                    </div>
                    <?php
                    echo '<img class="shop-item-image" src="' . base_url('uploads/' . $row->file_name) . '">' ;
                    ?>
                    <div class="shop-item-details">
                        <label class=" col-form-label" for="inputprice"> Price:</label>
                        <span class="shop-item-price" id="inputprice" > <?php echo $row->price; ?>  </span>
                        <label class="col-form-label" for="inputqty"> Qty: </label>
                        <span class="shop-item-qty" id="inputqty" >   <?php echo $row->qty; ?></span>    
                    </div>
                    <div class="shop-item-content">
                        <label class=" col-form-label" for="content"> Description:</label>
                        <span class="shop-item-price" id="content" > <?php echo $row->content; ?> </span>
                        
                    </div>
                    <div class="shop-item-details" >
                        <button class="btn btn-primary shop-item-button" style="width: 100%;" type="button">ADD TO CART</button>
                    </div>
                </div>
        <?php } ?>
    </div>
 </section>