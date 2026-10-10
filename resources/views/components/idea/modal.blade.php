@props(['idea' => new \App\Models\Idea()])
<x-modal 
    name="{{ $idea->exists ? 'edit-idea' : 'create-idea' }}" 
    title="{{ $idea->exists ? 'Edit Idea' : 'Create Idea' }}"
>
    <form 
        x-data="{
            status: @js(old('status', $idea->status->value)),
            newLink: '',
            links: @js(old('links', $idea->links ?? [])),
            newStep: '',
            steps: @js(old('steps', $idea->steps->map->only(['id', 'description', 'completed'])))
        }"
        method="POST"
        action="{{ $idea->exists ? route('ideas.update', $idea) : route('ideas.store') }}"
        enctype="multipart/form-data"
    >
        @csrf

        @if($idea->exists)
            @method('PATCH')
        @endif
        <div class="space-y-6">
            <x-form.field
                label="Title"
                name="title"
                placeholder="Enter an idea for your title"
                autofocus
                required
                :value="$idea->title"
            />

            <div class="space-y-2">
                <label for="status" class="label">Status</label>
                <div class="flex gap-x-3">
                    @foreach(App\IdeaStatus::cases() as $status)
                        <button 
                            type="button"
                            @click="status = @js($status->value)"
                            class="btn flex-1 h-10"
                            :class="{'btn-outlined': status !== @js($status->value)}"
                        >
                            {{ $status->label() }}
                        </button>
                    @endforeach
                    <input type="hidden" name="status" :value="status">
                </div>
                <x-form.error name="status"/>
            </div>

            <x-form.field
                label="Description"
                name="description"
                type="textarea"
                placeholder="Describe your idea..."
                :value="$idea->description"
            />

            <div class="space-y-2">
                <label for="image" class="label">Featured Image</label>
                @if($idea->image_path)
                    <div class="space-y-2">
                        <img src="{{ asset('storage/' . $idea->image_path) }}" alt="{{ $idea->title }}" class="w-full h-48 object-cover rounded-lg">
                        <button class="btn btn-outlined h-10 w-full" form="delete-image-form">Remove Image</button>
                    </div>
                @endif
                <input type="file" name="image" accept="image/">
                <x-form.error name="image"/>
            </div>

            <div>
                <fieldset class="space-y-2">
                    <legend class="label">Actionable Steps</legend>
            
                    <template x-for="(step, index) in steps" :key="step.id || index">
                        <div class="flex gap-x-2 items-center">
                            <input :name="`steps[${index}][description]`" x-model="step.description" class="input">
                            <input type="hidden" :name="`steps[${index}][completed]`" x-model="step.completed ? '1' : '0'" class="input">
                            <button
                                type="button"
                                aria-label="Remove step"
                                @click="steps.splice(index, 1)"
                                class="form-muted-icon"
                            >
                                <x-icons.close/>
                            </button>
                        </div>
                    </template>
            
                    <div class="flex gap-x-2 items-center">
                        <input 
                            x-model="newStep"
                            id="new-step"
                            placeholder="What needs to be done?"
                            class="input flex-1"
                            spellcheck="false"
                            @keydown.enter.prevent="if (newStep.trim()) { steps.push(newStep.trim()); newStep = ''; }"
                        >
                        <button
                            type="button"
                            @click="
                                steps.push({ description: newStep.trim(), completed: false });
                                newStep = '';
                            "
                            :disabled="newStep.trim().length === 0"
                            aria-label="Add step"
                            class="form-muted-icon"
                        >
                            <x-icons.close class="rotate-45"/>
                        </button>
                    </div>
                </fieldset>
            </div>


            <div>
                <fieldset class="space-y-2">
                    <legend class="label">Links</legend>
                    
                    <template x-for="(link, index) in links" :key="index">
                        <div class="flex gap-x-2 items-center">
                            <input 
                                name="links[]" 
                                :value="link" 
                                readonly 
                                class="input"
                            >
                            <button
                                type="button"
                                aria-label="Remove link"
                                @click="links.splice(index, 1)"
                                class="form-muted-icon"
                            >
                                <x-icons.close/>
                            </button>
                        </div>
                    </template>
            
                    <div class="flex gap-x-2 items-center">
                        <input 
                            x-model="newLink"
                            type="url"
                            id="new-link"
                            placeholder="http://example.com"
                            autocomplete="url"
                            class="input flex-1"
                            spellcheck="false"
                            @keydown.enter.prevent="if (newLink.trim()) { links.push(newLink.trim()); newLink = ''; }"
                        >
                        <button
                            type="button"
                            @click="if (newLink.trim()) { links.push(newLink.trim()); newLink = ''; }"
                            :disabled="newLink.trim().length === 0"
                            aria-label="Add link button"
                            class="form-muted-icon"
                        >
                            <x-icons.close class="rotate-45"/>
                        </button>
                    </div>
                </fieldset>
            </div>

            <div class="flex justify-end gap-x-5">
                <button type="button" @click="$dispatch('close-modal')">Cancel</button>
                <button type="submit" class="btn">{{ $idea->exists ? 'Update' : 'Create' }}</button>
            </div>
        </div>
    </form>
    @if($idea->image_path)
        <form method="POST" action="{{ route('ideas.image.destroy', $idea) }}" id="delete-image-form">
            @csrf
            @method('DELETE')
        </form>
    @endif
</x-modal>