@extends('layouts.app')

@section('title', 'MyNews')

@section('content')
	<div class="row">
		<div class="col-12">
			<h2 class="mb-4">MyNews</h2>
		</div>
	</div>

	<div class="row news-container">
		@include('news.partials.news_cards')
	</div>

	<div class="row mt-4">
		<div class="col-12 d-flex justify-content-center flex-column align-items-center">
			@if($news->hasMorePages())
				<button id="load-more" class="btn btn-primary mb-4"
						data-current-page="{{ $news->currentPage() }}"
						data-last-page="{{ $news->lastPage() }}">
					Загрузить ещё
				</button>
			@endif

			<div id="loading-spinner" class="text-center d-none mb-4">
				<div class="spinner-border text-primary" role="status">
					<span class="visually-hidden">Загрузка...</span>
				</div>
			</div>

			{{--        <div class="pagination-container">--}}
			{{--            {{ $news->links() }}--}}
			{{--        </div>--}}
		</div>
	</div>
@endsection

@section('scripts')
	<script>
        $(document).ready(function () {
            const loadMoreBtn = $('#load-more');
            const spinner = $('#loading-spinner');
            let isLoading = false;

            loadMoreBtn.on('click', function () {
                if (isLoading) return;

                const nextPage = parseInt($(this).data('current-page')) + 1;
                const lastPage = parseInt($(this).data('last-page'));

                loadMoreNews(nextPage, true);

                // Update button's current page
                $(this).data('current-page', nextPage);

                // Hide button if we've reached the last page
                if (nextPage >= lastPage) {
                    $(this).hide();
                }
            });

            $(document).on('click', '.pagination a', function (e) {
                e.preventDefault();
                if (isLoading) return;

                const page = $(this).attr('href').split('page=')[1];
                loadMoreNews(page, false);
            });

            function loadMoreNews(page, append = false) {
                isLoading = true;

                $.ajax({
                    url: "{{ route('news.load-more') }}",
                    data: {
                        page: page,
                        append: append
                    },
                    type: "get",
                    dataType: "json",
                    beforeSend: function () {
                        spinner.removeClass('d-none');
                        loadMoreBtn.prop('disabled', true);
                    }
                }).done(function (data) {
                    if (append) {
                        $('.news-container').append(data.html);
                    } else {
                        $('.news-container').html(data.html);
                        $('.pagination-container').html(data.pagination);

                        // Update URL without page reload
                        window.history.pushState("", "", "{{ route('news.index') }}?page=" + page);

                        // Scroll to top of news container
                        $('html, body').animate({
                            scrollTop: $('.news-container').offset().top - 100
                        }, 200);
                    }

                    // Update load more button
                    if (data.hasMorePages) {
                        loadMoreBtn.show();
                    } else {
                        loadMoreBtn.hide();
                    }

                }).fail(function (jqXHR, textStatus, errorThrown) {
                    console.error("Error loading news:", errorThrown);
                }).always(function () {
                    spinner.addClass('d-none');
                    loadMoreBtn.prop('disabled', false);
                    isLoading = false;
                });
            }
        });
	</script>
@endsection 