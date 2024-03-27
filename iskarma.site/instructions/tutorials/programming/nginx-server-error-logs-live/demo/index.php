<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nginx Error Log</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        h1 {
            margin-bottom: 20px;
        }
        .log-entry {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            margin: 10px auto;
            padding: 0px;
            border-radius: 5px;
            position: relative;
        }
        .log-time {
            font-weight: bold;
            color: #007bff;
            background: #eee;
            padding: 5px
        }
        .log-level {
            font-weight: bold;
            color: red;
            position: absolute;
            right: 0;
            top: 0;
            padding: 5px
        }
        .log-message {
            padding: 15px;
            font-size: 20px;
        }
        #flush-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 10px;
        }
        #flush-button:hover {
            background-color: #0056b3;
        }
        .sort-button {
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            margin-right: 10px;
        }
        .sort-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
    <h1>Nginx Error Log</h1>
    <button id="flush-button">Flush Log</button>
    <button class="sort-button" id="first-to-last-button">Sort First to Last</button>
    <button class="sort-button" id="last-to-first-button">Sort Last to First</button>
    <div id="log-content">
        <!-- Log content will be dynamically updated here -->
    </div>

    <script>
    $(document).ready(function() {
        var sortOrder = 'first-to-last'; // Initial sorting order


        function updateLog() {
            $.ajax({
                url: '/logs/nginx.error.log', // Path to your .log file
                type: 'GET',
                dataType: 'text', // Specify the data type as text
                success: function(data) {
                    // Split log content by newline characters
                    var logEntries = data.split('\n');

                    // Clear previous log entries
                    $('#log-content').empty();

                    // Sort log entries based on the selected order
                    if (sortOrder === 'last-to-first') {
                        logEntries.reverse();
                    }

                    // Format and append each log entry to the log-content div
                    logEntries.forEach(function(entry) {
                        if (entry.trim() !== '') {
                            // Split the log entry into individual elements
                            var elements = entry.split(': ');

                            // Extract time, level, and message
                            var time = elements[0];
                            var level = elements[1].split(' ')[0];
                            var message = elements.slice(1).join(' ');

                            // Create a container for the log entry
                            var logEntryContainer = $('<div class="log-entry"></div>');

                            // Add time, level, and message to the container
                            logEntryContainer.append('<div class="log-time">' + time + '</div>');
                            logEntryContainer.append('<div class="log-level">' + level + '</div>');
                            logEntryContainer.append('<div class="log-message">' + message + '</div>');

                            // Append the container to the log-content div
                            $('#log-content').append(logEntryContainer);
                        }
                    });
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching log content:', error);
                }
            });
        }

        // Function to flush the log file
        function flushLog() {
            $.ajax({
                url: 'flush_log.php', // Path to the script that handles the flush operation
                type: 'POST',
                success: function(response) {
                    // Log file flushed successfully
                    console.log('Log file flushed:', response);
                },
                error: function(xhr, status, error) {
                    console.error('Error flushing log file:', error);
                }
            });
        }

        // Initial call to updateLog function
        updateLog();

        // Schedule periodic updates every 5 seconds
        setInterval(updateLog, 5000); // 5000 milliseconds = 5 seconds

        // Event listener for the flush button click
        $('#flush-button').click(function() {
            flushLog();
        });

        // Event listener for sorting buttons
        $('#first-to-last-button').click(function() {
            sortOrder = 'first-to-last';
            updateLog(); // Re-sort and update log content
        });

        $('#last-to-first-button').click(function() {
            sortOrder = 'last-to-first';
            updateLog(); // Re-sort and update log content
        });
    });
    </script>
</body>
</html>
