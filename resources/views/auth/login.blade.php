<x-layout>
    <x-form title="Log in" description="Glad to have you back.">
        <form action="{{ route('login.store') }}" method="POST">
        @csrf
        <div class="space-y-4">
            <x-form.field name="email" label="Email" type="email"/>
             <x-form.field name="password" label="Password" type="password"/>
        </div>
        <button type="submit" class="btn mt-2 h-10 w-full">
            Sign in
        </button>
        </form>
    </x-form>
</x-layout>