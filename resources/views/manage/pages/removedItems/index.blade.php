@extends('manage.layout.app')

@section('title' , __('Removed Items'))

@section('content')
    <!--begin::Content-->
    <div id="kt_app_content" class="app-content ">
        <!--begin::Content container-->
        <div id="kt_app_content_container" class="app-container ">
            <!--begin::Row-->
            <div class="row g-5 g-xl-10 mb-5 mb-xl-10">
                <!-- begin::Card -->
                <div class="card">
                    <div class="card-header border-0 pt-6">
                        @include('manage.includes.search-component')
                        <div class="card-toolbar">

                        </div>
                    </div>
                    <div class="card-body pt-0 fs-6 py-8 px-8  px-lg-10 text-gray-700">
                        @include('manage.pages.removedItems.table')
                    </div>

                </div>
                <!-- end::Card -->
            </div>
            <!--end::Row-->
        </div>
        <!--end::Content container-->
    </div>
    <!--end::Content-->
@endsection
@section('scripts')
    <script src="{{ asset('manage/js/custom/removedItem/index.js') }}"></script>
@endsection
