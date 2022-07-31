<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>API</title>
</head>
<style>
    body {
        text-align: center;
    }
    table{
        margin: 0 auto;
    }
    code{
        background-color: black;
        color: orangered;
        padding: 10px;
        border-radius: 10px;
    }
    td, code{
        text-align: left;
        padding-right: 5px ;
    }
    tbody{
        height: 200px;
        
    }
</style>
<body>
    <h1>Hello World !</h1>
    <main>
        <div>
            <table>
                <thead>
                    <h2>Method GET</h2>
                </thead>
                <tbody>
                    <tr>
                        <td>Multiple Post</td>
                        <td><code>http://localhost:8000/post</code></td>
                    </tr>
                    <tr>
                        <td>One Post</td>
                        <td><code>http://localhost:8000/post?id=4</code></td>
                    </tr>
                    <tr>
                        <td>Posts with limit</td>
                        <td><code>http://localhost:8000/post?limit=5</code></td>
                    </tr>

                    <tr>
                        <td>Posts with order by</td>
                        <td><code>http://localhost:8000/post?order=desc&field=name</code></td>
                    </tr>

                    <tr>
                        <td>Posts slugs</td>
                        <td><code>http://localhost:8000/post?id=3&slug=1</code></td>
                    </tr>
                </tbody>  
            </table>
        </div>
    </main>
</body>
</html>