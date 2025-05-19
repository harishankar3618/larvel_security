<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScanController extends Controller
{
    public function showForm()
    {
        return view('scan.form');
    }

    public function scan(Request $request)
    {
        // Get the target URL from the form input
        $rawDomain = $request->input('target_url');

        // Trim spaces and quotes to avoid invalid target errors
        $domain = trim($rawDomain, " \t\n\r\0\x0B'\"");

        if (empty($domain)) {
            return view('scan.result', ['result' => 'Error: Target URL cannot be empty.']);
        }

        // Escape shell argument to avoid command injection
        $escapedDomain = escapeshellarg($domain);

        // Full path to your Python scanner script
        $path = 'C:\\Users\\hari shankar\\Documents\\vulnerability scanner\\vulnscanner\\security_scanner\\scanner.py';

        // Build the command (adjust python3 to python if needed)
        $command = "python3 \"$path\" $escapedDomain";

        // Execute the command and capture output
        $output = shell_exec($command);

        // Extract the generated JSON report filename from the output
        preg_match('/scan_report_\d+_\d+\.json/', $output, $matches);

        $scanResult = null;
        if (isset($matches[0])) {
            // Construct full path to the JSON report inside the public folder
            $reportFile = public_path($matches[0]);

            // Read and decode JSON if the file exists
            if (file_exists($reportFile)) {
                $jsonContent = file_get_contents($reportFile);
                $scanResult = json_decode($jsonContent, true);
            }
        }

        // Return view with raw output and parsed JSON result (if any)
        return view('scan.result', [
            'result' => $output,
            'scanResult' => $scanResult,
        ]);
    }
}
