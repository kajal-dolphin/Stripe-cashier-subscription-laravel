<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Renew Subscription Reminder</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        h4 {
            color: #007bff;
        }

        p {
            color: #555;
        }

        .btn {
            color: #fff;
            background-color: #28a745;
            border-color: #28a745;
        }

        .btn:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

    </style>
</head>
<body>
    <div class="container mt-5">
        <h4>Hello {{ $name }},</h4>

        <p>We hope this message finds you well. We wanted to remind you that your subscription for our <strong>{{ $stripe_plan }}</strong> plan is approaching its expiration date,
            set for <strong>{{ $expire_at }}</strong>. we want to ensure you continue to benefit from our services without interruption.</p>
        <div class="text-center">
            <a href="{{ route('subscription.resume', [$user_id, $stripe_plan]) }}" class="btn btn-lg btn-success">Resume Subscription</a>
        </div>

        <p class="mt-4">Should you choose to renew, you'll maintain access to all the features and benefits of your plan.
            We're committed to providing you with exceptional service and support along the way.</p>

        <p class="mt-4"><strong>Thank you,</strong></p>
    </div>
</body>
</html>
