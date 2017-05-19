<?php

class AwsController extends InitController
{
	public function __construct()
	{
		$_SESSION['layout'] = false;
	}

	public function wordAction()
	{
		$rows = array();

		return array(
			'rows' => $rows,
		);
	}

	public function rainAction()
	{
		return array();
	}

	public function aigitalrainAction()
	{
		return array();
	}
}