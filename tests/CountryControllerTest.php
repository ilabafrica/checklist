<?php
use App\Models\User;
use App\Models\Country;
use App\Http\Controllers\CountryController;
use App\Http\Requests\CountryRequest;
use Mockery as m;

class CountryControllerTest extends Illuminate\Foundation\Testing\TestCase {

	/**
	 * Creates the application.
	 *
	 * @return \Illuminate\Foundation\Application
	 */
	public function createApplication()
	{
		$app = require __DIR__.'/../bootstrap/app.php';

		$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

		return $app;
	}
	/* Setup function */
	public function setUp()
	{
		parent::setUp();
		$this->setVariables();
	}
	public function __construct()
	{
		// We have no interest in testing Eloquent
		$this->mock = m::mock('Country');
	}
	/**
	 * Contains the testing sample data for the CountryController.
	 *
	 * @return void
	 */
    public function setVariables()
    {
    	// Initial sample storage data
		$this->counData = array(
			'name' => 'TANZANIA',
			'code' => '255',
			'iso_3166_2' =>	'TZ',
			'iso_3166_3' =>	'TZA',
			'capital' =>	'Dodoma',
			'user_id' =>	'1',
		);
		//	Sample data with errors
		$this->counError = array(
			'name' => '',
			'code' => '256',
			'iso_3166_2' =>	'UG',
			'iso_3166_3' =>	'UGA',
			'capital' =>	'Kampala',
			'user_id' =>	'1',
		);

		
		// Edition sample data
		$this->counUpdate = array(
			'name' => 'TANZANIA',
			'code' => '255',
			'iso_3166_2' =>	'TZ',
			'iso_3166_3' =>	'TZA',
			'capital' =>	'Dar-es-salaam',
			'user_id' =>	'1',
		);
    }

	public function tearDown(){
		m::close();
	}
	/**
	 * Tests the index function in the CountryController
	 * @param  void
	 */
	public function testIndex()
 	{
	 	$this->mock
	 	->shouldReceive('all')
	 	->once()
	 	->andReturn('countries');

	 	$this->app->instance('Country', $this->mock);

	 	$this->call('GET', 'country/index');

	 	$this->assertResponseOk();
	}
	/**
	 * Tests the store function in the CountryController
	 * @param  void
	 * @return int $testCountryId ID of Country stored
	 */    
 	public function testStore() 
  	{
		echo "\n\COUNTRY CONTROLLER TEST\n\n";
  		 // Store the Country
        $input = Input::replace($this->counData);

        $this->mock
		->shouldReceive('create')
		->once()
		->with($input);

		$this->app->instance('Country', $this->mock);

		$this->call('POST', 'country');

		$this->assertRedirectedToRoute('country.index');
  	}
  	/* Test redirection to form if errors exist */
  	public function testStoreFails()
	{
		// Set stage for a failed validation
		Input::replace($this->counError);

		$this->app->instance('Post', $this->mock);

		$this->call('POST', 'country');
		// Failed validation should reload the create form
		$this->assertRedirectedToRoute('country.create');
		// The errors should be sent to the view
		$this->assertSessionHasErrors(['name']);
	}
	/* Test Success */
	public function testStoreSuccess()
	{
		Input::replace($input = $this->counData);

		Country::shouldReceive('create')->once();

		$this->call('POST', 'country');

		$this->assertRedirectedToRoute('country.index', ['message', 'active_country']);
	}
}