# ArduinoLibraryFootprintAnalyzer
A script (package) to analyze the footprints of Arduino librarer


## Idea and motivation
I recenctly added another library to extend the functionality to one of my projects. After compiling it used 100% of the available storage on my Arduino Micro.
Since the project itself isn't huge, I wondered what exactly used so much space. 
So I started to do some analysis.
For this I created an empty Project, only calling empty ```void loop( ) and void setup()``` to get an offset for the storage usage when compiled.
Afterwards I opened the (for me) most basic looking example provided with the library and compiled it, that gave me a second data point.
I did that with several libraries for the VL53L0X sensor.


| Library        | Example - ino used           | program storage used  | dynamic storage used   |
| ------------- |:-------------:| -----:| -----:|
| Empty sketch      | none | 3462 |149 |
| Adafruit_VL53L0X      | vl53l0x | 19346 |1201 |
| DFRobot_VL53L0X      | vl53l0x      |   8232 |  445 |
| Grove-Ranging-sensor-VL53L0X | continuous_ranging      |    18894 |1395 |
| vl53l0x-arduino | Continuous      |    9576 |431 |

The Arduino Micro I use has a total of
- 28672 Bytes program storage
- 2560 Bytes dynamic storage
The program storage offset is 3462 Bytes, so 25210 Bytes are remaining.

Adafruits library uses 15884, equal to 63% of it.

DFRobot_VL53L0X on the other side uses 4770 Bytes, equal to 19% of the avaiable program storage


After reviewing the results I decided that the differences are so huge, that I`ll write a script collection to collect that data automatically




