<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>

    </head>
    <body>
        <h1>Artisan UI</h1>
        @if ($errors->any())
            <div>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        @if (isset($exitCode))
            {{ $exitCode }}
        @endif
        @if (isset($output))
            {{ $output }}
        @endif
        @foreach ($sections as $section)
            <br/>
            <h2>{{ $section->id === "" ? __('artisan-ui::main.availableCommands') : $section->id }}</h2>
            <div style="margin: 0 25px;">
                @foreach ($section->commands as $command)
                    <form action="{{ route('artisan-ui.execute') }}" method="POST">
                        @csrf
                        <input type="hidden" name="command" value="{{ $command->getName() }}" />
                        <br/>
                        <h3>
                            {{ $command->getName() }}
                            <button type="submit">{{ __('artisan-ui::main.execute') }}</button>
                            {{-- TODO: ask for confirmation before executing a command that cannot be rolledback --}}
                        </h3>
                        <hr/>
                        <h4>{{ __('artisan-ui::main.description') }}</h4>
                        <p>{{ $command->getDescription() }}</p>
                        <h4>{{ __('artisan-ui::main.usage') }}</h4>
                        <p>php artisan {{ $command->getUsage() }}</p>
                        @if ($arguments = $command->getArguments())
                            <h4>{{ __('artisan-ui::main.arguments') }}</h4>
                            @foreach ($arguments as $argument)
                                <p>
                                    &lt;{{ $argument->getName() }}&gt;{{ $argument->isArray() ? '...' : '' }}<span style="margin-left: 25px;">{{ $argument->getDescription() }}</span>
                                    <input type="text" name="arguments[{{ $argument->getName() }}]"/>
                                </p>
                            @endforeach
                        @endif
                        @if ($options = $command->getOptions())
                            <h4>{{ __('artisan-ui::main.options') }}</h4>
                            @foreach ($options as $option)
                                <p>
                                    --{{ $option->getName() }}|-{{ $option->getShortcut() }}<span style="margin-left: 25px;">{{ $option->getDescription() }}</span>
                                    @if ($option->acceptValue())
                                        <input type="text" name="options[{{ $option->getName() }}]"/>
                                    @else
                                        <input type="checkbox" name="options[{{ $option->getName() }}]" required="{{ $option->isValueRequired() ? 'true' : 'false' }}" />
                                    @endif
                                </p>
                            @endforeach
                        @endif
                    </form>
                @endforeach
            </div>
        @endforeach
    </body>
</html>
