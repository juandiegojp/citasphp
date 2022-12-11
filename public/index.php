<?php session_start() ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.4/dist/flowbite.min.css" />
    <link href="/css/output.css" rel="stylesheet">
    <title>Portal</title>
</head>

<body>
    <?php
    require '../vendor/autoload.php';
    require '../src/_navbar.php';
    require '../src/_login.php';
    ?>
    <!-- Breadcrumb -->
    <nav class="flex px-5 py-3 text-gray-700 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-800 dark:border-gray-700" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="/" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-gray-900 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                    </svg>
                    Home
                </a>
            </li>
        </ol>
    </nav>

    <?php if (!\App\Tablas\Usuario::esta_logueado()) : ?>
        <div class="text-center">
            <h1 class="mb-4 text-4xl font-extrabold tracking-tight leading-none text-gray-900 md:text-5xl lg:text-6xl dark:text-white">
                ¿Necesitas ayuda?
            </h1>
            <p class="mb-6 text-lg font-normal text-gray-500 lg:text-xl sm:px-16 xl:px-48 dark:text-gray-400"> Coge tu cita AHORA.</p>
            <button class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button" data-modal-toggle="login">
                Login
            </button>
        </div>
    <?php else : ?>
        <div class="flex justify-between">
            <a href="/cita.php" class="flex flex-col items-center bg-white border rounded-lg shadow-md md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg" src="https://fhumanes.com/blog/wp-content/uploads/2020/11/citations_001.png" alt="">
                <div class="flex flex-col justify-between p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Solicitar una cita</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        Recuerda que no puedes solicitar una cita si ya tienes una ya. Para cualquier cambio, ve al panel de Gestion de Citas.
                    </p>
                </div>
            </a>

            <a href="/gestiones.php" class="flex flex-col items-center bg-white border rounded-lg shadow-md md:flex-row md:max-w-xl hover:bg-gray-100 dark:border-gray-700 dark:bg-gray-800 dark:hover:bg-gray-700">
                <img class="object-cover w-full rounded-t-lg h-96 md:h-auto md:w-48 md:rounded-none md:rounded-l-lg" src="https://www.audioenportada.com/images/stories/espana/profesion/2014/iStock_000014374627Medium.jpg" alt="">
                <div class="flex flex-col justify-between p-4 leading-normal">
                    <h5 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">Gestion de Citas</h5>
                    <p class="mb-3 font-normal text-gray-700 dark:text-gray-400">
                        Aquí puedes cancelar tus citas de ser necesario.
                    </p>
                </div>
            </a>
        </div>

        <?php
        $id = \App\Tablas\Usuario::logueado()->id;
        $pdo = conectar();
        $sent = $pdo->prepare('SELECT * FROM citas WHERE id_usuario = :id');
        $sent->execute([':id' => $id]);
        $filas = $sent->fetch(PDO::FETCH_ASSOC);
        ?>

        <?php if ($filas === false) : ?>
            <div class="mt-4">
                <h1 class="mb-4 text-3xl font-extrabold text-gray-900 dark:text-white md:text-5xl lg:text-6xl">
                    <span class="text-transparent bg-clip-text bg-gradient-to-r to-emerald-600 from-sky-400">
                        Upps...
                    </span>
                    ¡Nada que mostrar aquí!
                </h1>
                <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                    Parece ser que en tu historial aún no tienes ninguna cita con nosotros, ¿a qué esperas?
                </p>
            </div>
        <?php else : ?>
            <div class="mt-4 overflow-x-auto relative">
                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="py-3 px-6">
                                Nº cita
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Fecha
                            </th>
                            <th scope="col" class="py-3 px-6">
                                Hora
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($sent as $cita) : ?>
                            <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700">
                                <th scope="row" class="py-4 px-6 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    <?= $cita['id_cita'] ?>
                                </th>
                                <td class="py-4 px-6">
                                    <?= $cita['fecha'] ?>
                                </td>
                                <td class="py-4 px-6">
                                    <?= $cita['hora'] ?>
                                </td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            <?php endif ?>
            </div>
        <?php endif ?>

        <script src="https://unpkg.com/flowbite@1.5.4/dist/flowbite.js"></script>
</body>

</html>