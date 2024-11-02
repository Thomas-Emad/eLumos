@extends('layouts.dashboard')
@section('title', 'Roles')

@section('content-dashboard')
    <div class="container mx-auto min-h-auto-xl ">
        <div
            class="flex justify-between gap-2 items-center p-4 rounded-xl border border-gray-200 bg-white mb-2 dark:bg-gray-700 dark:border-gray-500">
            <h2 class="font-bold text-xl">Roles System</h2>
            <div class="flex justify-between gap-2 items-center">
                <button type="button"
                    class="users-settings bg-transparent font-bold text-amber-600 border border-amber-600 hover:bg-amber-600 hover:text-white rounded px-3 py-1 ms-3"
                    data-modal-target="users-settings" data-modal-toggle="users-settings">
                    Users
                </button>
                <button type="button"
                    class="bg-transparent font-bold text-green-600 border border-green-600 hover:bg-green-600 hover:text-white rounded px-3 py-1 ms-3"
                    data-modal-target="new-role" data-modal-toggle="new-role">
                    New Role
                </button>
            </div>
        </div>

        <div class="p-4 rounded-xl border border-gray-200 bg-white dark:bg-gray-700 dark:border-gray-500">
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                                Name
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Permission Used
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Users Used
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Created
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Action
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($roles as $role)
                            <tr class="bg-white border-b dark:bg-gray-900 dark:border-gray-700">
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ $role->name }}
                                </th>
                                <td class="px-6 py-4">
                                    <a href="#" data-modal-target='showPermissions' data-id="{{ $role->id }}"
                                        data-modal-toggle="showPermissions"
                                        class="hover:text-amber-700 duration-300 showPermission"
                                        title="show Permission This Role">
                                        {{ $role->permissions()->count() }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    {{ $role->users()->count() }}
                                </td>
                                <td class="px-6 py-4">
                                    {{ $role->created_at->shortAbsoluteDiffForHumans() }}
                                </td>
                                <td class="px-6 py-4">
                                    <a href="#" data-modal-target='setting-role' data-modal-toggle="setting-role"
                                        title="Settings For this Role" data-id="{{ $role->id }}"
                                        class="settings-role font-medium text-amber-600 dark:text-amber-500 hover:underline">Settings</a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-4 text-center">System Does not have any Role</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="text-sm px-4 py-2">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>


        {{-- Models --}}
        <div>
            {{-- Show  Model Permission --}}
            <x-modal id="showPermissions">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        <span>Show Permissions</span>
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="showPermissions">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4 bodyModal">
                </div>
            </x-modal>

            {{-- Settings Role Modal --}}
            <x-modal id="setting-role">
                <form action="{{ route('roles.update', 'setting') }}" method="POST">
                    @method('PATCH')
                    @csrf
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            <span>Settings This Role</span>
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="setting-role">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <div class="informaiton">
                            <x-input-icon class="" id="roleName" name="name" typeInput="text" title="Role Name"
                                defValue="" placeholder="Role Name">
                                <i class="fa-solid fa-heading text-gray-500 dark:text-gray-50"></i>
                            </x-input-icon>
                            <p><b>Users Count: </b><span class="usersCount"></span></p>
                            <p><b>Permissions Count: </b><span class="permissionsCount"></span></p>
                            <p><b>Created At: </b><span class="createdAt"></span></p>
                            <hr class="my-2 bg-gray-400">
                            <div>
                                <input type="hidden" name="id" id="id">
                                <h3 class="mb-2 mt-2 text-xl font-semibold text-gray-900 dark:text-white">Permissions:</h3>
                                <ul
                                    class="permissions w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">

                                </ul>
                            </div>
                        </div>
                        <hr>
                        <h3>Delete Role:</h3>
                        <button class="delete-role bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded"
                            type="button">Delete Role</button>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="setting-role" type="submit"
                            class="text-white bg-amber-700 hover:bg-amber-800 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800">
                            Save Changes
                        </button>
                        <button data-modal-hide="setting-role" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-amber-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                    </div>
                </form>
                <form action="{{ route('roles.destroy', 'destroy') }}" id="delete-role-form" method="POST">
                    @method('DELETE')
                    @csrf
                    <input type="hidden" name="id" class="delete-role-id">
                </form>
            </x-modal>

            {{-- Add new Role --}}
            <x-modal id="new-role">
                <form action="{{ route('roles.store', 'store') }}" method="POST">
                    @method('post')
                    @csrf
                    <!-- Modal header -->
                    <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                        <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                            <span>Add New Role</span>
                        </h3>
                        <button type="button"
                            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                            data-modal-hide="new-role">
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 14 14">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                            </svg>
                            <span class="sr-only">Close modal</span>
                        </button>
                    </div>
                    <!-- Modal body -->
                    <div class="p-4 md:p-5 space-y-4">
                        <div>
                            <x-input-icon class="" id="" name="name" typeInput="text"
                                title="Role Name" defValue="" placeholder="Role Name">
                                <i class="fa-solid fa-heading text-gray-500 dark:text-gray-50"></i>
                            </x-input-icon>

                            <hr class="my-2 bg-gray-400">
                            <div>
                                <h3 class="mb-2 mt-2 text-xl font-semibold text-gray-900 dark:text-white">Permissions:</h3>
                                <ul
                                    class="w-48 text-sm font-medium text-gray-900 bg-white border border-gray-200 rounded-lg dark:bg-gray-700 dark:border-gray-600 dark:text-white">
                                    @foreach ($permissions as $permission)
                                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                                            <div class="flex items-center ps-3">
                                                <input id="{{ $permission->name }}-checkbox" type="checkbox"
                                                    name="permissions[]" value="{{ $permission->id }}"
                                                    class="w-4 h-4 text-amber-600 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 dark:focus:ring-amber-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                                <label for="{{ $permission->name }}-checkbox"
                                                    class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ $permission->name }}</label>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Modal footer -->
                    <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                        <button data-modal-hide="new-role" type="submit"
                            class="text-white bg-amber-700 hover:bg-amber-800 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800">
                            Create
                        </button>
                        <button data-modal-hide="new-role" type="button"
                            class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-amber-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                    </div>
                </form>
            </x-modal>

            {{-- Users Roles --}}
            <x-modal id="users-settings">

                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
                        <span>Add New Role</span>
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 dark:text-gray-50 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
                        data-modal-hide="users-settings">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <div class="p-4 md:p-5 space-y-4">
                    <h3 class="mb-2 text-xl font-semibold text-gray-900 dark:text-white">Users:</h3>
                    <div class="w-full users">


                        <div class="relative overflow-x-auto sm:rounded-lg">
                            <div id="users-form"
                                class="flex items-center justify-between flex-column flex-wrap md:flex-row space-y-4 md:space-y-0 p-4 rounded-xl bg-gray-100 dark:bg-gray-800">
                                <select name='role'
                                    class="inline-flex items-center text-gray-500 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-3 py-1.5 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                    <option value="" selected>All</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->name }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                                <div class="flex gap-2 items-center">
                                    <label for="table-search" class="sr-only">Search</label>
                                    <div class="relative">
                                        <div
                                            class="absolute inset-y-0 rtl:inset-r-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                                <path stroke="currentColor" stroke-linecap="round"
                                                    stroke-linejoin="round" stroke-width="2"
                                                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                                            </svg>
                                        </div>
                                        <input type="text" id="table-search-users" name="search"
                                            class="block p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg w-80 bg-gray-50 focus:ring-amber-500 focus:border-amber-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500"
                                            placeholder="Search for users">
                                    </div>
                                    <button type="button" id="users-search"
                                        class="text-white text-sm bg-amber-700 hover:bg-amber-800 focus:ring-4 focus:outline-none focus:ring-amber-300 font-medium rounded-lg px-4 py-2 dark:bg-amber-600 dark:hover:bg-amber-700 dark:focus:ring-amber-800">Search</button>
                                </div>
                            </div>
                            <table
                                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 mt-2 rounded-xl">
                                <thead
                                    class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-800 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            #
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            NAMES
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            ROLE
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="users-table"></tbody>
                            </table>
                            <div class="links"></div>
                        </div>

                    </div>
                </div>
                <!-- Modal footer -->
                <div class="flex items-center p-4 md:p-5 border-t border-gray-200 rounded-b dark:border-gray-600">
                    <button data-modal-hide="users-settings" type="button"
                        class="w-full py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-amber-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">Close</button>
                </div>
            </x-modal>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(() => {

            // Show Permissions Model
            $(".showPermission").each(function() {
                $(this).click(function() {
                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: "POST",
                        url: "{{ route('roles.showRole') }}",
                        data: {
                            id: $(this).data('id'),
                        },
                        success: function(response) {
                            putDataInModalPermission(response)
                        },
                        dataType: 'json'
                    });
                })
            })

            function putDataInModalPermission(response) {
                let data = response
                data.permissions.map((permission) => {
                    $("#showPermissions .bodyModal").append(`
                        <span class="bg-amber-100 text-amber-800 font-medium me-2 px-2.5 py-0.5 rounded dark:bg-amber-900 dark:text-white">${permission['name']}</span>
                    `)
                })
            }
            // End Show Permissions Model

            // Make Actions in Role Modal
            $('.settings-role').each(function() {

                $(this).click(function() {
                    $("#loader").removeClass("hidden");

                    $.ajax({
                        headers: {
                            'X-CSRF-TOKEN': "{{ csrf_token() }}"
                        },
                        type: "POST",
                        url: "{{ route('roles.showRole') }}",
                        data: {
                            id: $(this).data('id'),
                        },
                        success: function(response) {
                            putDataInModalSettings(response)
                            $("#loader").addClass("hidden");
                        },
                        dataType: 'json'
                    });
                })
            })

            function putDataInModalSettings(response) {
                let data = response;
                $("#setting-role #id").val(data.id)
                $("#setting-role #roleName").val(data.name)
                $("#setting-role .usersCount").html(data.users_count)
                $("#setting-role .permissionsCount").html(data.permissions_count)
                $("#setting-role .createdAt").html(data.created)

                $('.delete-role-id').val(data.id)

                // put all permissions id in array
                let permissionsRole = []
                data.permissions.map((permission) => {
                    permissionsRole.push(permission['id'])
                })

                $("#setting-role .permissions").empty()
                data.all_permissions.map((permission) => {
                    $("#setting-role .permissions").append(`
                        <li class="w-full border-b border-gray-200 rounded-t-lg dark:border-gray-600">
                            <div class="flex items-center ps-3">
                                <input id="${permission['id']}-checkbox" type="checkbox" name="permissions[]" value="${permission['id']}" ${permissionsRole.includes(permission['id']) ? 'checked' : ''} class="w-4 h-4 text-amber-600 bg-gray-100 border-gray-300 rounded focus:ring-amber-500 dark:focus:ring-amber-600 dark:ring-offset-gray-700 dark:focus:ring-offset-gray-700 focus:ring-2 dark:bg-gray-600 dark:border-gray-500">
                                <label for="${permission['id']}-checkbox" class="w-full py-3 ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">${permission['name']}</label>
                            </div>
                        </li>
                    `)
                })
            }

            $('.delete-role').click(function() {
                $("#delete-role-form").submit();
            })
            // End Make Actions in Role Modal

            // Make Users in Role Modal
            $('.users-settings').click(function() {
                $("#loader").removeClass("hidden");
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: "GET",
                    url: "{{ route('roles.users') }}",
                    success: function(response) {
                        putDataInModalUsers(response)
                        $("#loader").addClass("hidden");
                    },
                    error: function(response) {
                        $("#loader").addClass("hidden");
                    },
                    dataType: 'json'
                });
            })

            function putDataInModalUsers(response) {
                $('.users-table').empty();

                response.data.map((user) => {
                    $('.users-table').append(
                        `
                        <tr class="bg-gray-100 border-b dark:bg-gray-900 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td class="w-4 p-4">
                                1
                            </td>
                            <th scope="row"
                                class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white flex gap-2">
                                <img class="w-10 h-10 rounded-full"
                                    src="{{ asset('assets/images/users/${user.photo}') }}" onerror="this.src='{{ asset('assets/images/user-1.png') }}'" alt="${user.name}">
                                <div class="ps-3">
                                    <div class="text-base font-semibold">${user.name}</div>
                                    <div class="font-normal text-gray-500">${user.email}</div>
                                </div>
                            </th>

                            <td class="px-6 py-4">
                                <form class="max-w-sm mx-auto role-form role-${user.id}" action="{{ route('roles.users.change') }}" method='post'>
                                    @csrf
                                    <input type="hidden" name="id" value="${user.id}">
                                    <select data-id='${user.id}' name='role' class="select-role bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-amber-500 focus:border-amber-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-amber-500 dark:focus:border-amber-500">` +
                        user.roles.map((role) => {
                            return `<option value="${role.name}" ${user.role_id == role.id ? 'selected' : ''}>${role.name}</option>`
                        }) +
                        `</select>
                                </form>
                            </td>
                        </tr>
                    `)
                })
                $(".role-form .select-role").change(function() {
                    $(`.role-${$(this).data('id')}`).submit()
                })

                if (response.data.length == 0) {
                    $('.users-table').append(`
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <td colspan="3"
                                class="px-6 py-4 text-gray-900 whitespace-nowrap dark:text-white">
                                    <div class="text-sm italic text-center">No Users</div>
                            </td>
                        </tr>
                    `)
                }
            }

            /* Search Users */
            $('#users-search').on('click', function() {
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': "{{ csrf_token() }}"
                    },
                    type: "GET",
                    data: {
                        search: ($('#users-form input[name="search"]').val()).toLowerCase(),
                        role: ($('#users-form select[name="role"]').val()).toLowerCase(),
                    },
                    url: "{{ route('roles.users') }}",
                    success: function(response) {
                        putDataInModalUsers(response)
                    },
                    error: function(response) {
                        console.log(response)
                    },
                })
            })
            // End Make Users in Role Modal
        })
    </script>
@endsection
