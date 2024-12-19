<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            color: #444;
        }
        h1 {
            text-align: center;
            margin-top: 30px;
            color: #2b3e16;
            font-size: 2.5em;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        form {
            width: 50%;
            margin: 40px auto;
            background-color: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        form div {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #2b3e16;
        }
        input[type="text"],
        input[type="email"],
        input[type="number"] {
            width: 100%;
            padding: 10px;
            font-size: 1em;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            transition: border-color 0.3s ease;
        }
        input:focus {
            border-color: rgb(41, 59, 24);
            outline: none;
            box-shadow: 0 0 5px rgba(41, 59, 24, 0.4);
        }
        button {
            display: block;
            width: 100%;
            padding: 10px;
            font-size: 1em;
            color: #fff;
            background-color: rgb(41, 59, 24);
            border: none;
            border-radius: 5px;
            cursor: pointer;
            text-transform: uppercase;
            font-weight: bold;
        }
        button:hover {
            background-color: #2b3e16;
        }
    </style>
</head>
<body>
    <h1>Edit User</h1>
    <form action="index.php?action=updateUser" method="post">
        <input type="hidden" name="Username" value="<?= htmlspecialchars($user['Username']) ?>">
        <div>
            <label for="Prenom">Prenom:</label>
            <input type="text" id="Prenom" name="Prenom" value="<?= htmlspecialchars($user['Prenom']) ?>" required>
        </div>
        <div>
            <label for="Nom">Nom:</label>
            <input type="text" id="Nom" name="Nom" value="<?= htmlspecialchars($user['Nom']) ?>" required>
        </div>
        <div>
            <label for="E_mail">Email:</label>
            <input type="email" id="E_mail" name="E_mail" value="<?= htmlspecialchars($user['E_mail']) ?>" required>
        </div>
        <div>
            <label for="Adresse">Adresse:</label>
            <input type="text" id="Adresse" name="Adresse" value="<?= htmlspecialchars($user['Adresse']) ?>" required>
        </div>
        <div>
            <label for="Tel">N° Tel:</label>
            <input type="number" id="Tel" name="Tel" value="<?= htmlspecialchars($user['Tel']) ?>" required>
        </div>
        <div>
            <button type="submit">Update User</button>
        </div>
    </form>
</body>
</html>
