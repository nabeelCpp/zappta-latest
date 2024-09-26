<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class Admin implements FilterInterface
{
	/**
	 * Do whatever processing this filter needs to do.
	 * By default it should not return anything during
	 * normal execution. However, when an abnormal state
	 * is found, it should return an instance of
	 * CodeIgniter\HTTP\Response. If it does, script
	 * execution will end and that Response will be
	 * sent back to the client, allowing for error pages,
	 * redirects, etc.
	 *
	 * @param RequestInterface $request
	 * @param array|null       $arguments
	 *
	 * @return mixed
	 */
	// public function before(RequestInterface $request, $arguments = null)
	// {
	// 	$uri = service('uri');
	// 	$url_segment = str_replace(base_url(), '', $uri);
	// 	$url_segment = explode('/', $url_segment);
	// 	if (count($url_segment) > 0 && $url_segment[1] == 'admincp') {
	// 		if (! session()->get('isLoggedIn')) {
	// 			// $segment = '/admincp/login';
	// 			// then redirct to login page
	// 			// return redirect()->to($segment); 
	// 			return redirect()->to('/admincp/login/?red=' . urlencode(current_url(true)));
	// 		}
	// 	}
	// }

	public function before(RequestInterface $request, $arguments = null)
	{
		// Get the current URI using service
		$uri = service('uri');

		// Ensure that $uri is not null
		if ($uri !== null) {
			// Remove base_url() from the current URI path
			$url_segment = str_replace(base_url(), '', $uri->getPath());

			// Explode the URL to get the segments
			$url_segment = explode('/', $url_segment);

			// Check if the second segment is 'admincp'
			if (count($url_segment) > 1 && $url_segment[1] === 'admincp') {
				// Check if the user is logged in
				if (!session()->get('isLoggedIn')) {
					// Redirect to the admin login page with the current URL as a redirection parameter
					return redirect()->to('/admincp/login/?red=' . urlencode(current_url(true)));
				}
			}
		}

		// If URI is null, you can handle it accordingly, though it's unlikely to be null here.
	}


	/**
	 * Allows After filters to inspect and modify the response
	 * object as needed. This method does not allow any way
	 * to stop execution of other after filters, short of
	 * throwing an Exception or Error.
	 *
	 * @param RequestInterface  $request
	 * @param ResponseInterface $response
	 * @param array|null        $arguments
	 *
	 * @return mixed
	 */
	public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
	{
		//
	}
}
