<?php
/**
 * @var \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Database\Eloquent\Builder|\App\Article[] $articles
 */
?>

@extends('layouts.moderator')

@section('title', e(__('New Articles')))

@section('content')

    <div class="card border">
        <div class="card-body">
            <form method="get" action="{{ route('moderator.articles.indexUpdateNeedImprovement') }}" class="form-inline">

                <div class="form-group">
                    {{ Form::text('Filter[title]', old('Filter[title]', request()->input('Filter.title')), ['class' => 'form-control',
                        'placeholder' => __('Title')]) }}
                </div>

                <div class="form-group">
                    {{ Form::text('Filter[user_id]', old('Filter[user_id]', request()->input('Filter.user_id')), ['class' => 'form-control',
                        'placeholder' => __('User Id')]) }}
                </div>

                <div class="form-group">
                    {{ Form::text('Filter[slug]', old('Filter[slug]', request()->input('Filter.slug')), ['class' => 'form-control',
                        'placeholder' => __('slug')]) }}
                </div>

                <div class="form-group">
                    {{ Form::submit(__('Submit'), ['class' => 'btn btn-outline-primary']) }}
                </div>

                <div class="form-group">
                    <a href="{{ route('moderator.articles.indexUpdateNeedImprovement') }}"
                       class="btn btn-link btn-sm'">{{__('Reset')}}</a>
                </div>

            </form>

        </div>
    </div>

    <div class="card card-primary card-outline">
        <div class="card-header">
            <h5 class="m-0">
                <i class="far fa-file-alt"></i> {{ __('Edit Need Improvement') }}
            </h5>
        </div>
        <div class="card-body p-0">

            <div class="table-responsive">
                <table class="table table-striped">
                    <thead class="thead-light">
                    <tr>
                        <th>
                            {!! link_to_route('moderator.articles.indexUpdateNeedImprovement', __('Id'),
                                array_merge(request()->query(), ['order' => 'id', 'dir' => $orderBy['dir'], 'page' => 1]) ) !!}
                        </th>
                        <th>
                            {!! link_to_route('moderator.articles.indexUpdateNeedImprovement', __('Title'),
                                array_merge(request()->query(), ['order' => 'title', 'dir' => $orderBy['dir'], 'page' => 1]) ) !!}
                        </th>
                        <th>
                            {!! link_to_route('moderator.articles.indexUpdateNeedImprovement', __('Slug'),
                                array_merge(request()->query(), ['order' => 'slug', 'dir' => $orderBy['dir'], 'page' => 1]) ) !!}
                        </th>
                        <th>{{ __('Author') }}</th>
                        <th>{{ __('Updated') }}</th>
                        <th>
                            {!! link_to_route('moderator.articles.indexUpdateNeedImprovement', __('Published'),
                            array_merge(request()->query(), ['order' => 'published_at', 'dir' => $orderBy['dir'], 'page' => 1]) ) !!}
                        </th>
                        <th>
                            {!! link_to_route('moderator.articles.indexUpdateNeedImprovement', __('Created'),
                                array_merge(request()->query(), ['order' => 'created_at', 'dir' => $orderBy['dir'], 'page' => 1]) ) !!}
                        </th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach ($articles as $article)
                        <tr>
                            <td>{{ $article->id }}</td>
                            <td>
                                <a href="{{ route('moderator.articles.updateNeedImprovementEdit', [$article->id]) }}">{{ $article->title }}</a>
                            </td>
                            <td>{{ $article->slug }}</td>
                            <td>{{ $article->user->username }}</td>
                            <td>{{ display_date_timezone($article->updated_at) }}</td>
                            <td>{{ display_date_timezone($article->published_at) }}</td>
                            <td>{{ display_date_timezone($article->created_at) }}</td>
                            <td class="d-inline-flex">
                                <div class="d-inline-flex">
                                    @if((int)$article->pay_type === 2 && !(bool)$article->paid)
                                        <a class="btn btn-sm btn-success"
                                           href="{{ route('moderator.articles.pay', [$article->id]) }}">
                                            <i class="fa fa-money"></i>
                                        </a>
                                    @endif

                                    {!! delete_form('moderator.articles.destroy', $article->id) !!}
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    @php unset($article); @endphp
                </table>

                {{ $articles->appends(request()->except(['page']))->links() }}
            </div>

        </div><!-- /.box-body -->
    </div>

@endsection
