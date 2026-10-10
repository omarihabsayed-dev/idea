<x-layout>
    <x-form title="Edit your account" description="Need to make a tweak?">
        <form action="{{ route('profile.update') }}" method="POST">
        @csrf
        @method('PATCH')
        <div class="space-y-4">
        <x-form.field name="name" label="Name" :value="$user->name"/>
        <x-form.field name="email" label="Email" type="email" :value="$user->email"/>
        <x-form.field name="password" label="New Password" type="password"/>
        </div>
        <button type="submit" class="btn mt-2 h-10 w-full">
            Update Account
        </button>
        </form>
    </x-form>
</x-layout>