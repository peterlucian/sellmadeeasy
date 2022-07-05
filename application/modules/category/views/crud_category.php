<div style="width: 100%;">
	<form action="<?php echo base_url('category/add_category'); ?>" method="post">
		<?php 
			echo validation_errors(); 
		?>
		<div class="form-group row">	
			<label class="col-sm-2 col-form-label" for="parent_id">Parent Category</label>
				<div class="col-sm-10">
					<?php
						$additional_dd_code='class="form-control"';
						$options['']= "Please select";
						foreach ($parent_cat->result() as $row){
							$options[$row->id]=$row->name;
						}

						echo form_dropdown('parent_id', $options,'',$additional_dd_code);
					?>
				</div>
		</div>
		<div class="form-group row">
			<label class="col-sm-2 col-form-label" for="parent_id">Category Name</label>
			<div class="col-sm-10">
				<input type="text" class="form-control" name="nome" placeholder="Nome" >
			</div>
		</div>
		<div class="form-group">
			<button type="submit" class="btn btn-primary btn-block">Adicionar categoria</button>
		</div>
	</form>
</div>
<div style="width: 100%;">
	<table id="category_table" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Name</th>
				<th>Parent Category</th>
                <th style="width: 275px;">Actions</th>
				
            </tr>
		</thead>
		<tbody>
            
			<?php
			$this->load->module('category');
			$base_url = base_url();
			foreach ($categorias->result() as $row)
				{  		
			?>
				<tr>
				<td> <?php echo $row->name; ?> </td>
				<?php
				if($row->parent_cat_id==0) {
					$parent_cat_title = "-";
				} else {
					$parent_cat_title=$this->category->_get_cat_title($row->parent_cat_id); 
				}
					
				?>
				<td><?php echo $parent_cat_title; ?></td>
				<?php
				if($row->parent_cat_id!=0) { ?>
				<td><a href="<?php echo $base_url; ?>category/delete_category/<?php echo $row->id; ?>"><i class="far fa-trash-alt fa-lg"></i></a></td>
				<?php } else { 
					echo "<td> </td>";
				}
					?>

				</tr>
			
			<?php
				}
			?>
        
            
            
        </tbody>
    </table>
</div>