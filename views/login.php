<!DOCTYPE html>
<html>

<head>
    <title>Athena - Login</title>
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            background-color: #f0f2f5;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;

        }

        .block {
            background-color: #ffffff;
            width: 100%;
            max-width: 400px;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);



        }

        .block__title {
            margin-bottom: 24px;
            color: #333;
            font-size: 1.8em;
            font-weight: 600;
        }

        .block__error {
            background-color: #ffebee;
            color: #c62828;
            padding: 10px;
            border-radius: 6px;
            font-size: 0.9em;
            margin-bottom: 15px;
            border: 1px solid #ffcdd2;

        }

        .block__form {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }

        .block__input {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 12px 15px;
            font-size: 1em;
            transition: border-color 0.3s ease;
        }

        .block__input:focus {
            outline: none;
            border-color: #7b2cbf;
        }

        .block__btn {
            padding: 12px;
            border-radius: 8px;
            border: none;
            color: white;
            background-color: #7b2cbf;
            font-size: 1em;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
            margin-bottom: 15px;
        }

        .block__btn:hover {
            background-color: #6a24a7;
        }

        .block__msg {
            font-family: sans-serif;
            text-align: center;

        }

        .block__link {
            color: #7b2cbf;
            text-decoration: none;
            font-weight: 600;
        }

        .block__link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <div class="block">
        <h1 class="block__title">Login</h1>
        <?php if (isset($error)): ?>
            <p class="block__error"><?php echo $error; ?></p>
        <?php endif; ?>
        <form class="block__form" method="POST" action="index.php?action=login">
            <input class="block__input" type="email" name="email" placeholder="Email" required>
            <input class="block__input" type="password" name="password" placeholder="Password" required>
            <button class="block__btn" type="submit">Login</button>
        </form>
        <p class="block__msg">Don't have an account? <a class="block__link" href="index.php?action=register">Register</a></p>
    </div>
</body>

</html>