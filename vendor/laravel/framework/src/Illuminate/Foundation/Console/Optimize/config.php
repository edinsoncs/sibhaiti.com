<?php

$basePath = $app['path.base'];

return array_map('realpath', array(
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/ClassLoader.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Container/Container.php',
    $basePath.'/vendor/symfony/http-kernel/Symfony/Component/HttpKernel/HttpKernelInterface.php',
    $basePath.'/vendor/symfony/http-kernel/Symfony/Component/HttpKernel/TerminableInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/Contracts/ResponsePreparerInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Foundation/Application.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Foundation/EnvironmentDetector.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Http/Request.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Http/FrameGuard.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/Request.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/ParameterBag.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/FileBag.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/ServerBag.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/HeaderBag.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/Session/SessionInterface.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/Session/SessionBagInterface.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/Session/Attribute/AttributeBagInterface.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/Session/Attribute/AttributeBag.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/Session/Storage/MetadataBag.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/AcceptHeaderItem.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/AcceptHeader.php',
    $basePath.'/vendor/symfony/debug/Symfony/Component/Debug/ExceptionHandler.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/ServiceProvider.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Exception/ExceptionServiceProvider.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Routing/RoutingServiceProvider.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Events/EventServiceProvider.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/Facades/Facade.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/Str.php',
    $basePath.'/vendor/symfony/debug/Symfony/Component/Debug/ErrorHandler.php',
    $basePath.'/vendor/symfony/http-kernel/Symfony/Component/HttpKernel/Debug/ErrorHandler.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Config/Repository.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/NamespacedItemResolver.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Config/FileLoader.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Config/LoaderInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Config/EnvironmentVariablesLoaderInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Config/FileEnvironmentVariablesLoader.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Config/EnvironmentVariables.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Filesystem/Filesystem.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Foundation/AliasLoader.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Foundation/ProviderRepository.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Cookie/CookieServiceProvider.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Database/DatabaseServiceProvider.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Encryption/EncryptionServiceProvider.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Filesystem/FilesystemServiceProvider.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Session/SessionServiceProvider.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/View/ViewServiceProvider.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Routing/RouteFiltererInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Routing/Router.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Routing/Route.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Routing/RouteCollection.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Routing/ControllerDispatcher.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Routing/UrlGenerator.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Routing/Matching/ValidatorInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Routing/Matching/HostValidator.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Routing/Matching/MethodValidator.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Routing/Matching/SchemeValidator.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Routing/Matching/UriValidator.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Workbench/WorkbenchServiceProvider.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Events/Dispatcher.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Database/Eloquent/Model.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/Contracts/ArrayableInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/Contracts/JsonableInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Database/DatabaseManager.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Database/ConnectionResolverInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Database/Connectors/ConnectionFactory.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Session/Middleware.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Session/Store.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Session/SessionManager.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/Manager.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Cookie/CookieJar.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Cookie/Guard.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Cookie/Queue.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Encryption/Encrypter.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/Facades/Log.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Log/LogServiceProvider.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Log/Writer.php',
    $basePath.'/vendor/monolog/monolog/src/Monolog/Logger.php',
    $basePath.'/vendor/psr/log/Psr/Log/LoggerInterface.php',
    $basePath.'/vendor/monolog/monolog/src/Monolog/Handler/AbstractHandler.php',
    $basePath.'/vendor/monolog/monolog/src/Monolog/Handler/AbstractProcessingHandler.php',
    $basePath.'/vendor/monolog/monolog/src/Monolog/Handler/StreamHandler.php',
    $basePath.'/vendor/monolog/monolog/src/Monolog/Handler/RotatingFileHandler.php',
    $basePath.'/vendor/monolog/monolog/src/Monolog/Handler/HandlerInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/Facades/App.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Exception/ExceptionDisplayerInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Exception/SymfonyDisplayer.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Exception/WhoopsDisplayer.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Exception/Handler.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/Facades/Route.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/View/Engines/EngineResolver.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/View/ViewFinderInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/View/FileViewFinder.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/View/Environment.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/Contracts/MessageProviderInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/MessageBag.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/Facades/View.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Support/Contracts/RenderableInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/View/View.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/View/Engines/EngineInterface.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/View/Engines/PhpEngine.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/Response.php',
    $basePath.'/vendor/laravel/framework/src/Illuminate/Http/Response.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/ResponseHeaderBag.php',
    $basePath.'/vendor/symfony/http-foundation/Symfony/Component/HttpFoundation/Cookie.php',
    $basePath.'/vendor/filp/whoops/src/Whoops/Run.php',
    $basePath.'/vendor/filp/whoops/src/Whoops/Handler/HandlerInterface.php',
    $basePath.'/vendor/filp/whoops/src/Whoops/Handler/Handler.php',
    $basePath.'/vendor/filp/whoops/src/Whoops/Handler/PrettyPageHandler.php',
    $basePath.'/vendor/filp/whoops/src/Whoops/Handler/JsonResponseHandler.php',
    $basePath.'/vendor/stack/builder/src/Stack/Builder.php',
    $basePath.'/vendor/stack/builder/src/Stack/StackedHttpKernel.php',
));