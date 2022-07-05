<?php 

echo validation_errors();
if (isset($message)){
	echo $message;	
} 
if (isset($error)){
	foreach ($error as $value){
		echo $value;
	}
} 


?>
<div style="width: 100%;">
	<table id="category_table" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Message</th>
				<th>Image</th>
				<th>Category</th>
                <th style="width: 275px;">Actions</th>
				
            </tr>
		</thead>
		<tbody>
            
			<?php
			$this->load->module('category');
			$base_url = base_url();
			foreach ($items->result() as $row)
				{  		
					if($this->session->userdata('id') == $row->user_id || $this->session->userdata('email')== "plnascimento@hotmail.com")
					{

					
			?>
				<tr>
				<td> <?php echo  $row->title; ?></td>
				<td> <?php echo $row->file_name; ?> </td>
				<?php $parent_cat_title=$this->category->_get_cat_title($row->categorie_id); ?>
				<td><?php echo $parent_cat_title; ?></td>
				<td><a href="<?php echo $base_url; ?>items/delete_items/<?php echo $row->id; ?>"><i class="far fa-trash-alt fa-lg"></i></a></td>
				</tr>
			
			<?php
					}
				}
			?>
        
            
            
        </tbody>
    </table>
</div>
<div style="width: 100%;">
	<form action="<?php echo base_url('items/add_item'); ?>" method="post" enctype="multipart/form-data">
		<div class="form-group row " style="padding: 15px 0;">
			<label class="col-sm-2 col-form-label" for="inputtitle">Title</label>
			<div class="col-sm-10">
				<input type="text" name="title" class="form-control" id="inputtitle" aria-describedby="emailHelp" placeholder="Enter title">	
			</div>
		</div>
		
		<div class="form-group row">	
			<label class="col-sm-2 col-form-label" for="parent_id">Category</label>
				<div class="col-sm-10">
					<?php
						$additional_dd_code='class="form-control"';
                        
						$this->load->module('category');
						$base_url = base_url();
						$marks = array();
						foreach ($categorias->result() as $row)
							{  
								if($row->parent_cat_id==0) {
									$marks += array( $row->name => array());
								} else {
									foreach ($marks as $key => $value){

										$parent_cat_title=$this->category->_get_cat_title($row->parent_cat_id); 
										if($key == $parent_cat_title){

											$marks[$key][] = $row->name . "#" . $row->id ; 

										}

									}

								}
                            }

                        $options= array();

                        foreach ($marks as $key => $value){
                                $options += array( $key => array());
                                foreach ($value as $something){
                                $pieces = explode("#", $something);
                                $options[$key][$pieces[1]] = $pieces[0];
                                }
                                
                        }
							
					

                        echo form_dropdown('categorie_id', $options,'',$additional_dd_code);
 
									
					?>
				</div>
		</div>
		<div class="input-group" style="padding: 15px 0;">
            <div class="input-group-prepend">
                <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
            </div>
            <div class="custom-file">
                <input type="file" class="custom-file-input" name="userfile" id="inputGroupFile01" aria-describedby="inputGroupFileAddon01">
                <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
            </div>
        </div>
		<!-- <div class="form-group">
			<input type="file" name="userfile" size="20" />
		</div> -->
		<div class="form-group">				
			<textarea name="tiny">Next, use our Get Started docs to setup Tiny!</textarea>
		</div>
		<div class="form-group row">
			<label class="col-sm-1 col-form-label" for="inputprice">Price</label>
			<div class="col-sm-4">
				<input type="text" name="price" class="form-control" id="inputprice" aria-describedby="emailHelp" placeholder="Enter price">	
			</div>
			<div class="input-group-append col-sm-1">
    			<span class="input-group-text" style="height: 40px;">€</span>
  			</div>
			<label class="col-sm-1 col-form-label" for="inputqty">Quantity</label>
			<div class="col-sm-3">
				<input type="text" name="qty" class="form-control" id="inputqty" aria-describedby="emailHelp" placeholder="Enter quantity">
			</diV>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Adicionar Item</button>
		</div>
		
	</form>
</div>
