<?php

trait GetOverview
{
	public function getOverview()
	{
		// keep adding overview elements as you build them..
		// start with hello world!
		$this->report[] = array(
			'api' => 'Dashboard',
			'response' => 'got-dashboard-overview',
			'content' => 'this is the dashboard stuff that can be displayed on this page!',
			'got-dashboard-overview' => true
		);

		return;

	} // end method getOverview();

} // end trait GetOverview

?>