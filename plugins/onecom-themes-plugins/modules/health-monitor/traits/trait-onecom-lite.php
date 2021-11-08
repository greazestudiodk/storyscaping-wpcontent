<?php

trait OnecomLite {

	function onecom_is_premium() {
	    $features = oc_set_premi_flag();
		if ( isset( $features['data'] ) && ( ! empty( $features['data'] ) ) && ( in_array( 'MWP_ADDON', $features['data'] ) ) ) {
			return true;
		}
		return false;
	}

	function onecom_premium_filter( $subtitle ) {
		if ( ! $this->onecom_is_premium() ) {
			return '';
		}

		return $subtitle;
	}
}