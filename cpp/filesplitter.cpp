/*
 * AUTHOR: 		David Shu
 * DESCRIPTION: This is a simple program that will take an input file and split it into multiple files
 * 				based on part size specified and produce a checksum file with md5 checksums for each file.
 * 				The part size denotes the size of the individual files in the resulting output.
 * INPUT: 		1) filename including relevant path
 * 				2) size of file parts in bits
 * OUTPUT: 		files numbered with a suffix and 1 checksum file
 * NOTES:		uses openssl library for md5 functionality
 */
#include <fstream>
#include <iostream>
#include <math.h>
#include <string>
#include <sstream>
#include <openssl/md5.h>
#include <iomanip>
#include <stdlib.h>

using namespace std;

// md5 wrapper function
void md5sum(unsigned char * input, int len, char * output){
	unsigned char digest[MD5_DIGEST_LENGTH];

	MD5(input,len,digest);

	for(int j=0;j<16;j++){
		sprintf(&output[j*2],"%02x",(unsigned int)digest[j]);
	}
} // END md5sum Function

void splitFile(char * fname, int partsize){
	ifstream file(fname,ios::in|ios::binary|ios::ate);
		if(file.is_open()){
			ifstream::pos_type size = file.tellg();
			stringstream checksum;
			file.seekg(0,ios::beg);

			if(partsize >= size){
				throw "Partsize is greater then Filesize.";
				return;
			}

			for(int i=0;i<=floor(size/partsize);i++){
				char mdString[33];
				char * memblock;
				ifstream::pos_type cpos = file.tellg();
				int diff = size -cpos;

				int writesize = 0;

				if(diff >= partsize){
					writesize = partsize;
				}else if(diff > 0){
					writesize = diff;
				}

				memblock = new char[writesize];
				file.read(memblock,writesize);
				stringstream ofile;
				ofile<<fname;
				ofile<<setfill('0')<<setw(5)<<i;
				ofstream outfile(ofile.str().c_str(),ios::out|ios::binary);
				if(outfile.is_open()){
					outfile.write(memblock,writesize);
					outfile.close();
				}else{
					stringstream err;
					err<<"failed to open "<<ofile.str()<<" for writing";
					delete[] memblock;
					throw err.str().c_str();
				}

				md5sum((unsigned char *) memblock,writesize,mdString);
				checksum<<ofile.str()<<"\t"<<(int) cpos<<"-"<<(int) (cpos)+writesize<<"\t"<<mdString<<endl;
				delete[] memblock;

			} // END FOR LOOP

			file.close();
			stringstream cfile;
			cfile<<fname<<"_checksum";
			ofstream cksumfile(cfile.str().c_str(),ios::out);
			if(cksumfile.is_open()){
				cksumfile<<checksum.str();
				cksumfile.close();
			}else{
				throw "failed to open checksum file for writing.";
			}

		}else{
			throw "failed to open input file.";
		} // END open input file IF - ELSE
} // END function splitFile

int main(int argc,char * argv[]){
	if(argc < 3){
		cout<<"invalid number of arguments"<<endl;
		cout<<"usage: udtserver <file> <partsize>"<<endl;
		return 0;
	}
	try{
		splitFile(argv[1], atoi(argv[2]));
	}catch(const char * err){
		cout<<"ERROR: "<<err<<endl;
		return 0;
	}
} // END main
