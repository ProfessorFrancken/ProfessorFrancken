# T.F.V. Professor Francken
This is the (not yet public) repository containing code for the new website of
[T.F.V. Porfessor Francken](http://professorfrancken.nl/).
We are using the [Laravel v5.2](http://laravel.com/docs/5.2) framework in
combination with [Broadway](http://github.com/qandidate-labs/broadway), an
infrastructure library for creating CQRS and Event Sourced applications.

You can find some high quality introductory videos on
[laravelfromscratch.com](laravelfromscratch.com).

## Setting up a VM
You should first install [virtualbox](https://www.virtualbox.org/wiki/Downloads)
and [vagrant](https://www.vagrantup.com/).
Vagrant is used to provision our VM.
You will now need to download Homestead, e.g. by cloning the repository:
```
git clone https://github.com/laravel/homestead.git Homestead
```

### Generate a ssh key
If you do not yet have an ssh key (if you've installed
[Github Desktop](https://desktop.github.com/) then you can skip this step) then
you should generate a new, see
[generating a new ssh key](https://help.github.com/articles/generating-a-new-ssh-key/).

Next copy and rename the `Homestead.yaml.dist` file to `Homestead.yaml`, also
copy and rename the `.env.example` file to `.env`.
If you are on windows, then change the `authorize` property in `Homestead.yaml` to point to your
public ssh key.

### Setup homestead
Once virtualbox and thereafter vagrant have been installed and you've correctly
cloned Homestead and configured your sshkey, then you should install the
`homestead` box:
```
vagrant box add laravel/homestead
```
Downloading the box might take a while.

Next you *should* be able to run `vagrant up`, which starts the VM,
```
vagrant up
```
Once vagrant has finished you can ssh into the VM by using `vagrant ssh`. The VM
is automatically configured with nginx and MYSQL database. See the
[homestead documentation](https://laravel.com/docs/5.2/homestead) for some
additional info.

### Verify that everything is working
Once you've successfully ssh'd into your VM you'll need to install some
dependencies using [composer](http://getcomposer.org/).
Next `cd` into the `francken` directory and then run `composer install`.
Once that's finished you should be able to run the unit and integration tests,
```
vendor/bin/phpunit
```

Next if you want to visit the website you should run some migrations (these will
configure your MYSQL database) and setup an random application key (this is used
for security stuff),
```
php artisan key:generate
php artisan migrate
```

### Configure your hosts file
In order to actually visit the website you will have to configure your (local,
so not the VM's)
`/etc/hosts` file to redirect `francken.app` to `192.168.10.10`, by adding the
next line to your `/etc/hosts` file (this requires root permission, so use sudo)
```
sudo echo "192.168.10.10  francken.app" >> /etc/hosts
```

#### Another option is to use the xip.io service
Instead of configuring your host file you should also be able to open the
website by visiting [francken.192.168.10.10.xip.io/](http://francken.192.168.10.10.xip.io/).

## Testing
Once your VM has been setup you should be able to run the unit and integration
tests and verify that everything is working correctly.

Run the tests from your VM in the root directory:
```
vendor/bin/phpunit
```
