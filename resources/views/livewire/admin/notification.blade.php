<div class="bg-gray-100 ">



    {{-- alert --}}
    <div>
        @if (session()->has('message'))
            <div id="alert-border-3"
                class="justify-center flex p-4  mb-4 text-green-800 border-t-4 border-green-300 bg-green-50 dark:text-green-400 dark:bg-gray-800 dark:border-green-800"
                role="alert">
                <div class="ml-3 text-xl font-medium">
                    {{ session('message') }}
                </div> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <svg class=" flex-shrink-0 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd"
                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                        clip-rule="evenodd"></path>
                </svg>
            </div>
        @endif
    </div>
{{-- end alert  --}}
    <div class="py-4">
        <div class="text-center">
            <x-jet-button wire:click="createShowModal"  class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                {{ __('انشاء اشعار') }}
            </x-jet-button>
        </div>
    </div>

    {{-- table data --}}

    <div class="px-5  bg-white-500 ">
        <div class="overflow-auto rounded-lg shadow  md:block">
            <table class="w-full">
                <thead class="bg-gray-700 border-b-2 border-gray-200 text-white">
                    <tr>

                        <th class="w-5 px-2 py-3 text-sm  text-left   text-white uppercase">
                           #</th>
                        <th class="w-40 py-3  text-sm  tracking-wide text-left   text-white uppercase">
                            الرساله</th>
                        <th class=" w-15  py-3  text-sm  tracking-wide text-left   text-white uppercase">
                            العنوان </th>
                        <th class=" w-25 py-3  text-sm  tracking-wide text-left   text-white uppercase">
                            تم الانشاء</th>
                        <th class="w-20  py-3  text-sm  tracking-wide text-center   text-white uppercase"
                            colspan="2">
                            العمليات</th>

                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100 italic font-semibold">
                    @if (is_null($notifications))
                        <div class="alert alert-warning">
                            <strong>Sorry!</strong> لايوجد اشعارات.
                        </div>
                    @else
                    @foreach ($notifications as $notification)
                    <tr class="bg-white">
                        <td class="w-5  px-2   text-sm  whitespace-nowrap border-b">
                            {{ $notification->id }}
                        </td>
                        <td class="w-40   py-4  text-sm  whitespace-nowrap border-b">
                            {{ $notification->massage }}
                        </td>
                        <td class="w-15  py-4 text-sm whitespace-nowrap border-b">
                            {{ $notification->title }}</td>
                        <td class="w-25  py-4 text-sm whitespace-nowrap border-b">
                            {{ $notification->created_at }}</td>

                        <td class="w-10  py-4 text-sm whitespace-nowrap border-b">
                            <x-jet-button wire:click="updateShowModel({{ $notification->id }})"
                                class="text-white bg-gradient-to-r from-green-400 via-green-500 to-green-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-green-300 dark:focus:ring-green-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
                                >
                                {{ __('تعديل') }}
                            </x-jet-button>
                        </td>
                        <td class="w-10 p-2  py-4 text-sm whitespace-nowrap border-b">
                            <x-jet-danger-button wire:click="deletShowModel({{ $notification->id }})" class="text-white bg-gradient-to-r from-red-400 via-red-500 to-red-600 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2">
                                {{ __('حذف') }}
                                </x-jet-button>
                        </td>
                    </tr>
                @endforeach
                    @endif


                </tbody>
            </table>
        </div>
        <div class="p-2 ">
            {{ $notifications->links('pagination-links') }}
        </div>
    </div>

    {{-- Model form --}}
    <x-jet-dialog-modal wire:model="modalFormVisable">
        <x-slot name="title">
            {{ __('انشاء اشعار') }}
        </x-slot>
        <x-slot name="content">
            {{-- {{ __('Are you sure you want to Crate Notification ?') }} --}}
            <div class="mt-4">
                <x-jet-label for="massage" value="{{ __('الرساله :') }}" />
                <x-jet-input id="massage" class="block mt-1 w-full" type="text" wire:model="massage" required />
                <div class="bg-red-700 ">
                    @error('massage')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
            <div class="mt-4">
                <x-jet-label for="title" value="{{ __('العنوان:') }}" />
                <x-jet-input id="title" class="block mt-1 w-full" type="text" wire:model="title" required />
                <div class="bg-red-700 ">
                    @error('title')
                        <span class="error">{{ $message }}</span>
                    @enderror
                </div>
            </div>
        </x-slot>

        <x-slot name="footer">
            <x-jet-danger-button wire:click="$toggle('modalFormVisable')" wire:loading.attr="disabled">
                {{ __('الغاء') }}
            </x-jet-danger-button>

            @if ($modelId)
                <x-jet-secondary-button class="ml-3" wire:click="update" wire:loading.attr="disabled">
                    {{ __('تعديل') }}
                </x-jet-secondary-button>
                <x-slot name="title">
                    {{ __('تعديل الاشعار') }}
                </x-slot>
            @else
                <x-jet-secondary-button class="ml-3" wire:click="create" wire:loading.attr="disabled">
                    {{ __('حفظ') }}
                </x-jet-secondary-button>
            @endif
        </x-slot>
    </x-jet-dialog-modal>

    {{-- delet model form  --}}
    <x-jet-dialog-modal wire:model="modalConfirmDeletVisable">
        <x-slot name="title">
            {{ __('حذف الاشعار ') }}
        </x-slot>
        <x-slot name="content">
            {{ __('هل انت متأكد من عمليه الحذف ؟ ') }}
        </x-slot>
        <x-slot name="footer">
            <x-jet-danger-button wire:click="cancel" wire:loading.attr="disabled">
                {{ __('الغاء') }}
            </x-jet-danger-button>
            <x-jet-secondary-button class="ml-3" wire:click="delete" wire:loading.attr="disabled">
                {{ __('حذف الاشعار') }}
            </x-jet-secondary-button>
        </x-slot>
    </x-jet-dialog-modal>
</div>
