<?php
$comoslides .= '<div class="item carousel-item '. $slideclass .'" data-bs-interval="'. $slider_interval .'" '. $slideAria .'>'. $slide['image'];
if ($slider_captions == 'show') {
	if ($slide['title'] || $slide['subtitle'] || $slide['content'] || $slide['button-text'] || $slide['link']) {
		
		// Color Override
		$colorOverride = (($slide['color']) ? 'style="color: '. $slide['color'] .'"' : '');
		
		// Caption Wrap
		$comoslides .= '<div class="carousel-caption"><div class="container">';
		$comoslides .= '<div class="caption-wrap';
		//$comoslides .= (($cslide == 0) ? ' hide' : ''); // Hide caption wrap on first slide to avoid page load flicker 
		if ($slide['comoslide-caption-animation']) {
			$comoslides .= ' animated no-flick hide" ';						
			$comoslides .= 'data-animation="animated '. $slide['comoslide-caption-animation'] .'"';
		} else {
			$comoslides .= '"';
		}
		$comoslides .= '><div class="caption-border-absolute"></div><div class="caption-bg-absolute"></div><div class="caption-border"><div class="caption-inner">';
		// Title
		if ($slide['title']) {
			$comoslides .= '<div class="comoslide-title-wrap">';
			$comoslides .= '<h2 class="comoslide-title';
			if ($slide['comoslide-title-animation']) {
				$comoslides .= ' animated no-flick hide" ';
				$comoslides .= ' data-animation="animated '. $slide['comoslide-title-animation'] .'"';	
			} else {
				$comoslides .= '"';
			}
			$comoslides .= $colorOverride;
			$comoslides .= '>'. $slide['title'] .'</h2>';
			$comoslides .= '</div><!-- /comoslide-title-wrap -->';
		}
		// Subtitle
		if ($slide['subtitle']) {
			$comoslides .= '<div class="comoslide-subtitle-wrap">';
			$comoslides .= '<p class="comoslide-subtitle';
			if ($slide['comoslide-subtitle-animation']) {
				$comoslides .= ' animated no-flick hide" ';
				$comoslides .= 'data-animation="animated '. $slide['comoslide-subtitle-animation'] .'"';
			} else {
				$comoslides .= '"';
			}
			$comoslides .= $colorOverride;
			$comoslides .= '>'. $slide['subtitle'] .'</p>';
			$comoslides .= '</div><!-- /comoslide-subtitle-wrap -->';
		}
		// Content
		if ($slide['content']) {
			$comoslides .= '<div class="comoslide-content-wrap">';
			$comoslides .= '<div class="comoslide-content';
			if ($slide['comoslide-content-animation']) {
				$comoslides .= ' animated no-flick hide" ';
				$comoslides .= 'data-animation="animated '. $slide['comoslide-content-animation'] .'"';
			} else {
				$comoslides .= '"';
			}
			$comoslides .= $colorOverride;
			$comoslides .= '>'. $slide['content'] .'</div>';
			$comoslides .= '</div><!-- /comoslide-content-wrap -->';
		}
		// Button inside Caption Box
		if ($slide['button-location']=='inside') {
			if ($slide['button-text'] || $slide['link']) {
				$comoslides .= '<p class="comoslide-btn-wrap';
				if ($slide['comoslide-btn-animation']) {
					$comoslides .= ' animated no-flick hide" ';
					$comoslides .= 'data-animation="animated '. $slide['comoslide-btn-animation'] .'"';
				} else {
					$comoslides .= '"';
				}
				$comoslides .= '>';
				
				$linkTarget = (($slide['link-target']) ? 'target="'. $slide['link-target'] .'"' : '');
				$comoslides .= (($slide['link']) ? '<a class="btn btn-slider" href="'. $slide['link'] .'" '. $linkTarget .'>' : '');
				$comoslides .= (($slide['button-text']) ? $slide['button-text'] : ((($slide['link'])) ? 'Learn More' : ''));
				$comoslides .= (($slide['link']) ? '</a>' : '');
				$comoslides .= '</p>';
			}
			if ($slide['button-text-2'] || $slide['link-2']) {
				$comoslides .= '<p class="comoslide-btn-wrap';
				if ($slide['comoslide-btn-animation']) {
					$comoslides .= ' animated no-flick hide" ';
					$comoslides .= 'data-animation="animated '. $slide['comoslide-btn-animation'] .'"';
				} else {
					$comoslides .= '"';
				}
				$comoslides .= '>';
				
				$linkTarget = (($slide['link-target-2']) ? 'target="'. $slide['link-target-2'] .'"' : '');
				$comoslides .= (($slide['link-2']) ? '<a class="btn btn-slider" href="'. $slide['link-2'] .'" '. $linkTarget .'>' : '');
				$comoslides .= (($slide['button-text-2']) ? $slide['button-text-2'] : ((($slide['link-2'])) ? 'Learn More' : ''));
				$comoslides .= (($slide['link-2']) ? '</a>' : '');
				$comoslides .= '</p>';
			}
		}
		$comoslides .= '</div><!-- /caption-inner --></div><!-- /caption-border -->';
		$comoslides .= '</div><!-- /caption-wrap -->';
		// Button Outside Caption Box						
		if ($slide['button-location']=='outside') {
			if ($slide['button-text'] || $slide['link']) {
				$comoslides .= '<div class="comoslide-btn-wrap outside';
				if ($slide['comoslide-btn-animation']) {
					$comoslides .= ' animated no-flick hide" ';
					$comoslides .= 'data-animation="animated '. $slide['comoslide-btn-animation'] .'"';
				} else {
					$comoslides .= '"';
				}
				$comoslides .= '>';
				$comoslides .= (($slide['link']) ? '<a class="btn btn-slider" href="'. $slide['link'] .'">' : '');
				$comoslides .= (($slide['button-text']) ? $slide['button-text'] : ((($slide['link'])) ? 'Learn More' : ''));
				$comoslides .= (($slide['link']) ? '</a>' : '');
				$comoslides .= '</div>';
			}
			if ($slide['button-text-2'] || $slide['link-2']) {
				$comoslides .= '<div class="comoslide-btn-wrap outside';
				if ($slide['comoslide-btn-animation']) {
					$comoslides .= ' animated no-flick hide" ';
					$comoslides .= 'data-animation="animated '. $slide['comoslide-btn-animation'] .'"';
				} else {
					$comoslides .= '"';
				}
				$comoslides .= '>';
				$comoslides .= (($slide['link-2']) ? '<a class="btn btn-slider" href="'. $slide['link-2'] .'">' : '');
				$comoslides .= (($slide['button-text-2']) ? $slide['button-text-2'] : ((($slide['link-2'])) ? 'Learn More' : ''));
				$comoslides .= (($slide['link-2']) ? '</a>' : '');
				$comoslides .= '</div>';
			}
		}
		$comoslides .= '</div><!-- /container --></div><!-- /carousel-caption -->';
	}
}
$comoslides .= '</div>';
$comoindicators .= '<li data-target="#'. $slider_name .'" data-bs-target="#'. $slider_name .'" data-slide-to="'. $cslide .'" data-bs-slide-to="'. $cslide .'" class="'. $slideclass .'" ></li>';
//  This can be used to override the default Carousel Next/Previous Buttons
//$comocarousel_controls = '';
?>