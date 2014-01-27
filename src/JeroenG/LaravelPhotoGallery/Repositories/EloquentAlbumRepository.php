<?php namespace JeroenG\LaravelPhotoGallery\Repositories;

use JeroenG\LaravelPhotoGallery\Models\Album;

class EloquentAlbumRepository implements AlbumRepository {
	
	public function all()
	{
		return Album::all();
	}

	public function find($id)
	{
		return Album::find($id);
	}

	public function findOrFail($id)
	{
		return Album::findOrFail($id);
	}

	public function create($input)
	{
		return Album::create($input);
	}

	public function update($id, $input)
	{
		$album = $this->find($id);
		$album->album_name = $input['album_name'];
		$album->album_description = $input['album_description'];
		$album->touch();
		return $album->save();
	}

	public function delete($id)
	{
		$album = $this->find($id);
		$albumPhotos = $album->photos;
		$photoRepository = \App::make('Repositories\PhotoRepository');

		foreach ($albumPhotos as $photo) {
			$photoRepository->delete($photo->photo_id);
		}
		return $album->delete();
	}
}