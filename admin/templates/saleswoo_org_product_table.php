<?php
/**
 * Exit if accessed directly
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}
?>
<div class="saleswooo_list">
	<?php
	$saleswoo_product_table = new SaleswooOrgAccountTable();
	$saleswoo_product_table->prepare_items();
    ?>
    <form class ="saleswoo-connect-form" method="POST">
        <?php $saleswoo_product_table->display(); ?>
    </form>
</div>
<?php
if( ! class_exists( 'WP_List_Table' ) ) {
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}
class SaleswooOrgAccountTable extends WP_List_Table{
    
    /*
    * Prepare Table Items
    */
    public function prepare_items() {

	 	$perPage = 5;
        $columns = $this->get_columns();
        $hidden = array();
        $sortable = array();

        $this->_column_headers = array($columns, $hidden, $sortable);

        $data = $this->table_data();

        $currentPage = $this->get_pagenum();
        $totalItems = count($data);
        $this->set_pagination_args( array(
            'total_items' => $totalItems,
            'per_page'    => $perPage
        ) );
        $data = array_slice($data,(($currentPage-1)*$perPage),$perPage);
        $this->items = $data;
    }

    /* 
    * Get table columns
    */
    public function get_columns() {

        $columns = array(
        'name'                          => 'Name',
        'saleswoo_product_id'           => 'Salesforce Product Id',
        'action'                        => 'Action'
        );
        return $columns;
    }

    /* 
    * Get table data
    */
    private function table_data() {
    	$temp_data = array();

        $args = array(
            'numberposts'   => -1,
            'post_type'     => array( 'product','product_varitaion' ),
            'post_status'   => array( 'publish' ),
        );

		$wcProductsArray = get_posts( $args );

        if( is_array( $wcProductsArray ) && count( $wcProductsArray ) ) {

            foreach( $wcProductsArray as $single_product ) {

                $id           =  $single_product->ID ;

                $product      = wc_get_product( $id );

                $product_type = $product->get_type();

                if($product_type == "variable"){

                    $variations=$product->get_available_variations();

                    foreach ($variations as $value) {

                        $variation_id       = $value['variation_id'];

                        $single_variation   = wc_get_product($variation_id);

                        $vartion_data       = $single_variation->get_data();

                        $variation_name     = $vartion_data['name'];

                        $saleswoo_product_id = get_post_meta($variation_id,'saleswoo_org_product_id',true);

                        if(!empty($saleswoo_product_id)){
                            $status = "<button type='button' data-prodid=".$id."  id='saleswoo_single_product' class='saleswoo_delete'>".__('Delete', 'saleswoo-org')."</button>";
                        }
                        else{
                            $status = "<button type='button' data-prodid=".$id."  id='saleswoo_single_product_upload' class='saleswoo_upload'>".__('Upload', 'saleswoo-org')."</button>";
                        }
                        
                        $new_data = array(
                            'name'                          => $variation_name,
                            'saleswoo_product_id'           => !empty($saleswoo_product_id) ? $saleswoo_product_id : "-",
                            'action'                        => $status
                        );

                        $temp_data[] = $new_data;
                    }
                }
                else{

                    $product_name        = $product->get_name();

                    $saleswoo_product_id = get_post_meta($id,'saleswoo_org_product_id',true);

                    if(!empty($saleswoo_product_id)){
                        $status = "<button type='button' data-prodid=".$id."  id='saleswoo_single_product' class='saleswoo_delete'>".__('Delete', 'saleswoo-org')."</button>";
                    }
                    else{
                        $status = "<button type='button' data-prodid=".$id."  id='saleswoo_single_product_upload' class='saleswoo_upload'>".__('Upload', 'saleswoo-org')."</button>";
                    }

                    $new_data = array(
                        'name'                          => $product_name,
                        'saleswoo_product_id'           => !empty($saleswoo_product_id) ? $saleswoo_product_id : "-",
                        'action'                        => $status
                        
                    );

                    $temp_data[] = $new_data;
                }
            }
        }
		return $temp_data;  
    }

    /* 
    * Get table default columns
    */
    public function column_default( $item, $column_name ) {

        switch( $column_name ) {
            case 'name':
            case 'saleswoo_product_id':
            case 'action':
                return $item[ $column_name ];
            default:
                return print_r( $item, true ) ;
        }
    }
}
?>
