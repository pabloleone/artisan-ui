<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />

        <title>Artisan UI</title>

        <!-- Bootstrap -->
        <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">
        <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.1.3/js/bootstrap.bundle.min.js"></script>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

        <style>
          #wrapper {
            overflow-x: hidden;
          }

          #sidebar-wrapper {
            min-height: 100vh;
            margin-left: -15rem;
            transition: margin 0.25s ease-out;
          }

          #sidebar-wrapper .sidebar-heading {
            padding: 0.875rem 1.25rem;
            font-size: 1.2rem;
          }

          #sidebar-wrapper .list-group {
            width: 15rem;
          }

          #accordion-sections {
            border-left: 1px solid rgba(0,0,0,.125);
          }

          body.sb-sidenav-toggled #wrapper #sidebar-wrapper {
            margin-left: 0;
          }

          @media (min-width: 768px) {
            #sidebar-wrapper {
              margin-left: 0;
            }

            #page-content-wrapper {
              min-width: 0;
              width: 100%;
            }

            body.sb-sidenav-toggled #wrapper #sidebar-wrapper {
              margin-left: -15rem;
            }
          }
        </style>

        <script>
            function onChange(object) {
                const value = object.value;
                scrollToCommand(value);
            }

            function scrollToCommand(value) {
                window.location.href = value;
            }
        </script>
    </head>
    <body>

        <!-- Mobile navigation -->
        <nav class="d-block d-sm-block d-md-block d-lg-none navbar navbar-expand-lg navbar-light bg-light fixed-top">
            <div class="container-fluid">
                <select id="navigation" class="form-select form-select-sm" onchange="onChange(this)" aria-label=".form-select-sm example">
                    <option selected>Open this select menu</option>
                    @foreach ($sections as $key => $section)
                        <optgroup label="{{ $section->getId() === "" ? __('artisan-ui::main.availableCommands') : $section->getId() }}">
                            @foreach ($section->getCommands() as $command)
                                <option value="#{{ Str::snake($command->getName()) }}">{{ $command->getName() }}</option>
                            @endforeach
                        </optgroup>
                    @endforeach
                </select>
            </div>
        </nav>

        <div class="container d-flex flex-column vh-100 overflow-hidden" id="wrapper">
            <div class="row flex-grow-1 overflow-hidden">

                <!-- Sidebar navigation -->
                <nav class="d-none d-lg-block col-2 mh-100 overflow-auto py-0 px-0 border-end bg-white w-25" id="sidebar-wrapper">
                    <div class="accordion accordion-flush" id="accordion-sections">
                        @foreach ($sections as $key => $section)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $key }}">
                                <button
                                    class="accordion-button collapsed"
                                    type="button"
                                    data-bs-toggle="collapse"
                                    data-bs-target="#collapse{{ $key }}"
                                    aria-expanded="false"
                                    aria-controls="collapse{{ $key }}"
                                >
                                    {{ $section->getId() === "" ? __('artisan-ui::main.availableCommands') : $section->getId() }}
                                </button>
                                </h2>
                                <div
                                    id="collapse{{ $key }}"
                                    class="accordion-collapse collapse"
                                    aria-labelledby="heading{{ $key }}"
                                    data-bs-parent="#accordionExample"
                                >
                                    <div class="accordion-body p-1">
                                        @foreach ($section->getCommands() as $command)
                                            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="#{{ Str::snake($command->getName()) }}">
                                                {{ $command->getName() }}
                                            </a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </nav>

                <!-- Page wrapper-->
                <div class="col mh-100 overflow-auto" id="page-content-wrapper">

                    <!-- Page content-->
                    <div class="container-fluid px-2 py-4">
                        @if (isset($errors) && $errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="mb-4 alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong>{{ __('artisan-ui::main.error') }}!</strong> {{ $error }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            @endforeach
                        @endif

                        @if (isset($exitCode) || isset($output))
                            <div class="mb-4 alert alert-success alert-dismissible fade show" role="alert">
                                {{ $output ?? '' }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        @endif

                        @foreach ($sections as $section)
                            @foreach ($section->getCommands() as $command)

                                <!-- Card -->
                                <div class="card mb-4">
                                    <form action="{{ route('artisan-ui.execute') }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="command" value="{{ $command->getName() }}" />

                                        <!-- Card header -->
                                        <div class="card-header d-flex justify-content-between align-items-center">
                                            <a id="{{ Str::snake($command->getName()) }}" href="#{{ Str::snake($command->getName()) }}">
                                                #{{ $command->getName() }}
                                            </a>
                                            <div class="btn-group" role="group">
                                                @if (count($command->getArguments()) > 0 || count($command->getOptions()) > 0)
                                                    <button
                                                        class="btn btn-secondary btn-sm"
                                                        type="button"
                                                        data-bs-toggle="collapse"
                                                        data-bs-target="#collapseTryOut{{ Str::replace(':', '', Str::snake($command->getName())) }}"
                                                        role="button"
                                                        aria-expanded="false"
                                                        aria-controls="collapseTryOut{{ Str::replace(':', '', Str::snake($command->getName())) }}"
                                                    >{{ __('artisan-ui::main.tryOut') }}</button>
                                                @endif
                                                <button class="btn btn-primary btn-sm" type="submit">{{ __('artisan-ui::main.execute') }}</button>
                                            </div>
                                        </div>

                                        <!-- Card content -->
                                        <div class="card-body">
                                            <h4>{{ __('artisan-ui::main.description') }}</h4>
                                            <p>{{ $command->getDescription() }}</p>
                                            <h4>{{ __('artisan-ui::main.usage') }}</h4>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="p-3">
                                                        php artisan {{ $command->getUsage() }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Card footer-->
                                        <div class="card-footer collapse" id="collapseTryOut{{ Str::replace(':', '', Str::snake($command->getName())) }}">
                                            @if ($arguments = $command->getArguments())
                                                <h4>{{ __('artisan-ui::main.arguments') }}</h4>
                                                @foreach ($arguments as $argument)
                                                    <div class="mb-3">
                                                        <label for="option" class="form-label">&lt;{{ $argument->getName() }}&gt;{{ $argument->isArray() ? '...' : '' }}</label>
                                                        <input type="text" class="form-control" id="arguments-{{ Str::slug($argument->getName()) }}" name="arguments[{{ $argument->getName() }}]" placeholder="{{ $argument->getDescription() }}" />
                                                    </div>
                                                @endforeach
                                            @endif
                                            @if ($options = $command->getOptions())
                                                <h4>{{ __('artisan-ui::main.options') }}</h4>
                                                @foreach ($options as $option)
                                                    <p>
                                                        @if ($option->acceptValue())
                                                            <div class="mb-3">
                                                                <label for="option" class="form-label">--{{ $option->getName() }}{{ $option->isArray() ? '...' : '' }}</label>
                                                                <input type="text" class="form-control" id="options-{{ Str::slug($option->getName()) }}" name="options[{{ $option->getName() }}]" placeholder="{{ $option->getDescription() }}" />
                                                            </div>
                                                        @else
                                                            <div class="mb-3 form-check">
                                                                <input type="checkbox" class="form-check-input" aria-describedby="{{ Str::slug($option->getName()) }}-help" id="{{ Str::slug($option->getName()) }}" name="options[{{ $option->getName() }}]" />
                                                                <label class="form-check-label" for="{{ Str::slug($option->getName()) }}">--{{ $option->getName() }}</label>
                                                                <div id="{{ Str::slug($option->getName()) }}-help" class="form-text">{{ $option->getDescription() }}</div>
                                                            </div>
                                                        @endif
                                                    </p>
                                                @endforeach
                                            @endif
                                            <div class="d-grid gap-2 mb-2">
                                                <button class="btn btn-primary" type="submit">{{ __('artisan-ui::main.execute') }}</button>
                                            </div>
                                        </div>

                                    </form>
                                </div>
                            @endforeach
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </body>
</html>
