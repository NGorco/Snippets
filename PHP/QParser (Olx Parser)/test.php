<?php

require_once getcwd() . "/QParser.php";

new OlxParser(
	Array
	(
		"url" => "http://kiev.ko.olx.ua/nedvizhimost/arenda-kvartir/dolgosrochnaya-arenda-kvartir/?search%5Bfilter_float_price%3Ato%5D=6000&search%5B",
		"proxy" => "136.0.16.217:7808",
		"mail_opts" => array
		(
			"to" => "your_mail@mail.com",
			"subject" => "Квартиры с OLX за " . date("m.d.Y H:i"),
			"headers" => Array
			(
				"From: Olx Parser Mail <noreply@nono.com>",
				"Reply-To: Olx Parser Mail <noreply@nono.com>",
				"X-Mailer: PHP/".phpversion()
			)
		)
	)
);

?>