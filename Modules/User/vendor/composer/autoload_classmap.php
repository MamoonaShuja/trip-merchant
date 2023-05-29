<?php

// autoload_classmap.php @generated by Composer

$vendorDir = dirname(dirname(__FILE__));
$baseDir = dirname($vendorDir);

return array(
    'Composer\\InstalledVersions' => $vendorDir . '/composer/InstalledVersions.php',
    'Modules\\User\\Constants\\UserFiles' => $baseDir . '/Constants/UserFiles.php',
    'Modules\\User\\Contracts\\Repositories\\UserRepositoryContract' => $baseDir . '/Contracts/Repositories/UserRepositoryContract.php',
    'Modules\\User\\Contracts\\Services\\AccessTokenContract' => $baseDir . '/Contracts/Services/AccessTokenContract.php',
    'Modules\\User\\Contracts\\Services\\UserContract' => $baseDir . '/Contracts/Services/UserContract.php',
    'Modules\\User\\DataTransfer\\Requests\\ChangePasswordDTO' => $baseDir . '/DataTransfer/Requests/ChangePasswordDTO.php',
    'Modules\\User\\DataTransfer\\Requests\\ForgetPasswordDTO' => $baseDir . '/DataTransfer/Requests/ForgetPasswordDTO.php',
    'Modules\\User\\DataTransfer\\Requests\\ResetPasswordDTO' => $baseDir . '/DataTransfer/Requests/ResetPasswordDTO.php',
    'Modules\\User\\DataTransfer\\Requests\\SignInDTO' => $baseDir . '/DataTransfer/Requests/SignInDTO.php',
    'Modules\\User\\DataTransfer\\Requests\\SignUpDTO' => $baseDir . '/DataTransfer/Requests/SignUpDTO.php',
    'Modules\\User\\DataTransfer\\Requests\\UpdateUserDTO' => $baseDir . '/DataTransfer/Requests/UpdateUserDTO.php',
    'Modules\\User\\DataTransfer\\Requests\\UploadAvatarDTO' => $baseDir . '/DataTransfer/Requests/UploadAvatarDTO.php',
    'Modules\\User\\Database\\Seeders\\UserDatabaseSeeder' => $baseDir . '/Database/Seeders/UserDatabaseSeeder.php',
    'Modules\\User\\Database\\factories\\UserFactory' => $baseDir . '/Database/factories/UserFactory.php',
    'Modules\\User\\Entities\\User' => $baseDir . '/Entities/User.php',
    'Modules\\User\\Enum\\UserType' => $baseDir . '/Enum/UserType.php',
    'Modules\\User\\Http\\Controllers\\AuthenticationController' => $baseDir . '/Http/Controllers/AuthenticationController.php',
    'Modules\\User\\Http\\Controllers\\UserController' => $baseDir . '/Http/Controllers/UserController.php',
    'Modules\\User\\Http\\Requests\\Authentication\\ForgetPasswordRequest' => $baseDir . '/Http/Requests/Authentication/ForgetPasswordRequest.php',
    'Modules\\User\\Http\\Requests\\Authentication\\ResetPasswordRequest' => $baseDir . '/Http/Requests/Authentication/ResetPasswordRequest.php',
    'Modules\\User\\Http\\Requests\\Authentication\\SignInRequest' => $baseDir . '/Http/Requests/Authentication/SignInRequest.php',
    'Modules\\User\\Http\\Requests\\Authentication\\SignInTwoFactorRequest' => $baseDir . '/Http/Requests/Authentication/SignInTwoFactorRequest.php',
    'Modules\\User\\Http\\Requests\\Authentication\\SignUpRequest' => $baseDir . '/Http/Requests/Authentication/SignUpRequest.php',
    'Modules\\User\\Http\\Requests\\UserUpdateRequest' => $baseDir . '/Http/Requests/UserUpdateRequest.php',
    'Modules\\User\\Observers\\UserObserver' => $baseDir . '/Observers/UserObserver.php',
    'Modules\\User\\Providers\\RouteServiceProvider' => $baseDir . '/Providers/RouteServiceProvider.php',
    'Modules\\User\\Providers\\UserServiceProvider' => $baseDir . '/Providers/UserServiceProvider.php',
    'Modules\\User\\Repositories\\UserRepository' => $baseDir . '/Repositories/UserRepository.php',
    'Modules\\User\\Services\\AccessTokenService' => $baseDir . '/Services/AccessTokenService.php',
    'Modules\\User\\Services\\UserService' => $baseDir . '/Services/UserService.php',
);