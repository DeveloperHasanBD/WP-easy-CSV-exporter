
/**
 * Template name: CSV Exporter
 */

csv_generator();
function csv_generator()
{
	header('Content-Type: text/csv; charset=utf-8');
	header('Content-Disposition: attachment; filename=cards.csv');
	echo "\xEF\xBB\xBF";

	$cards_args = array(
		'post_type' => 'cards',
		'posts_per_page' => -1,
	);
	$cards_query = new WP_Query($cards_args);

	$output = fopen("php://output", "w");
	fputcsv($output, array('ID', 'Title'));

	if ($cards_query->have_posts()) {
		while ($cards_query->have_posts()) {
			$cards_query->the_post();

			$data           		=  [];
			$data['id']     		= get_the_ID();
			$data['title']     		= get_the_title();


			fputcsv($output, $data);
			// echo "<pre>";
			// print_r($data);
		}
		wp_reset_query();
	}

	fclose($output);
	exit();
}
