<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

function tagline()
{
	$quotes = array(
		'In color',
		'In Hypno-Vision',
		'Featuring gratuitious alien nudity',
		'Presented in DoubleVision (where drunk)',
		'Transmitido en martion en SAP',
		'Made from CSC-20021 by-products',
		'Not Y3K compliant',
		'Based on a true story',
		'From the maker of Celestia and Nova2',
		'The site that browses back',
		'Nominated for three Webbys',
		'Coming soon to Tor',
		'As foretold by Nostrodamus',
		'A stern warning of things to come',
		'Simulcast on crazy people\'s filligs',
		'Larva tested, pupa approved',
		'For external use only',
		'Painstakingly coded before a live audience',
		'Touch eyeballs to screen for cheap laser surgery',
		'Smell-O-Vision users insert nostril tubes now',
		'Not a substitute for human interaction',
		'Secreted by the comedy bee',
		'If not entertaining write to your MP',
		'Now with Chucklelin',
		'Torn from tomorrow\'s headlines',
		'80% JavaScript by volume',
		'Deciphered from crop circles',
		'Please rise for the Tundra theme song',
		'Krafted wiv luv by monsters',
		'Disclaimer: any resemblance to actual website would be really cool',
		'UK law prohibits changing the URL',
		'For proper browsing take red pill now',
		'Scratch here to reveal prize',
		'Hey Amazon! Suggest this!',
		'Fun for the whole family (except Grandma and Grampa)',
		'Please turn off all scrapers',
		'Love it or shove it',
		'If accidentally viewed, induce vomiting',
		'Bigfoot\'s choice',
		'When you see the robot, drink!',
		'Soon to be a major religion',
		'Or is it?',
		'Controlling you through a chip in your butt since 2011',
		'Not affiliated with Tundra Brass Knuckle Co.',
		'Known to cause insanity in <del>freshers</del> laboratory mice',
		'Dancing space potatoes? You bet!',
		'A by-product of the software industry',
		'Too hot for TV',
		'You can\'t prove it won\'t happen',
		'Beats a hard kick in the face',
		'Voted "best"',
		
		'Like...bus',
		'Ninja said WHAT?!',
		'Pssst! Party at your place after the beta!',
		'I should be learning C++ instead of doing this',
		'This one time, on Tundra, there were widgets everywhaaahhh',
		'An export of the Independent Republic of Goodvillebriggereys',
		'No gotos were used during the making of this website',
		'Schadenfreude...fuck you lady, that\'s that iGoogle\'s for'
	);
	
	return $quotes[mt_rand(0, count($quotes) - 1)];
}
?>